<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'department_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'document_type_id',
        'status',
        'uploaded_by',
        'approved_by',
        'approved_at',
        'is_public',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'is_public' => 'boolean',
    ];


    // Status types
    const STATUS_DRAFT = 'draft';
    const STATUS_APPROVED = 'approved';
    const STATUS_ARCHIVED = 'archived';

    /**
     * Get the user who uploaded the document
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the user who approved the document
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get document type
     */
    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    /**
     * Get status name in Vietnamese
     */
    public function getStatusName(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT => 'Bản nháp',
            self::STATUS_APPROVED => 'Đã phê duyệt',
            self::STATUS_ARCHIVED => 'Lưu trữ',
            default => 'Không xác định',
        };
    }

    /**
     * Get document type name
     */
    public function getDocumentTypeName(): string
    {
        return $this->documentType ? $this->documentType->name : 'Không xác định';
    }

    /**
     * Get document type CSS class for badge
     */
    public function getDocumentTypeCssClass(): string
    {
        if (!$this->documentType) {
            return 'other';
        }

        // Map document type names to CSS classes
        return match($this->documentType->name) {
            'BAN CHỈ ĐẠO ISO' => 'policy',
            'TÀI LIỆU HỆ THỐNG ISO' => 'procedure', 
            'TÀI LIỆU NỘI BỘ' => 'manual',
            'VĂN BẢN QUẢN LÝ' => 'form',
            default => 'other',
        };
    }

    /**
     * Get file size in human readable format
     */
    public function getFormattedFileSize(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get document permissions
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(DocumentPermission::class);
    }

    /**
     * Check if user has permission to view document
     */
    public function canUserView(User $user): bool
    {
        // Admin can view all documents
        if ($user->role == User::ROLE_ADMIN) {
            return true;
        }

        // Level 1 (Ban ISO) can view all documents they uploaded or all documents if is_public
        if ($user->role == User::ROLE_LEVEL1) {
            return $this->uploaded_by == $user->id || $this->is_public;
        }

        // Level 2 (Cơ quan - Phân xưởng) can only view if they have permission or document is public
        if ($user->role == User::ROLE_LEVEL2) {
            return $this->is_public || $this->permissions()->where('user_id', $user->id)->where('can_view', true)->exists();
        }

        // Level 3 (Người sử dụng) can only view public documents
        if ($user->role == User::ROLE_LEVEL3) {
            return $this->is_public;
        }

        return false;
    }

    /**
     * Check if user has permission to download document
     */
    public function canUserDownload(User $user): bool
    {
        // Admin can download all documents
        if ($user->role == User::ROLE_ADMIN) {
            return true;
        }

        // Level 1 (Ban ISO) can download all documents they uploaded or all documents if is_public
        if ($user->role == User::ROLE_LEVEL1) {
            return $this->uploaded_by == $user->id || $this->is_public;
        }

        // Level 2 (Cơ quan - Phân xưởng) can only download if they have permission or document is public
        if ($user->role == User::ROLE_LEVEL2) {
            return $this->is_public || $this->permissions()->where('user_id', $user->id)->where('can_download', true)->exists();
        }

        // Level 3 (Người sử dụng) can only download public documents
        if ($user->role == User::ROLE_LEVEL3) {
            return $this->is_public;
        }

        return false;
    }
}
