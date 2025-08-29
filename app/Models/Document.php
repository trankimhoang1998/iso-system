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
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'document_type',
        'status',
        'version',
        'uploaded_by',
        'approved_by',
        'approved_at',
        'effective_date',
        'expiry_date',
        'tags',
        'is_public',
    ];

    protected $casts = [
        'tags' => 'array',
        'approved_at' => 'datetime',
        'effective_date' => 'date',
        'expiry_date' => 'date',
        'is_public' => 'boolean',
    ];

    // Document types
    const TYPE_POLICY = 'policy';
    const TYPE_PROCEDURE = 'procedure';
    const TYPE_FORM = 'form';
    const TYPE_MANUAL = 'manual';
    const TYPE_REPORT = 'report';
    const TYPE_OTHER = 'other';

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

    /**
     * Get the user who approved the document
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get document type name in Vietnamese
     */
    public function getDocumentTypeName(): string
    {
        return match($this->document_type) {
            self::TYPE_POLICY => 'Chính sách',
            self::TYPE_PROCEDURE => 'Quy trình',
            self::TYPE_FORM => 'Biểu mẫu',
            self::TYPE_MANUAL => 'Hướng dẫn',
            self::TYPE_REPORT => 'Báo cáo',
            self::TYPE_OTHER => 'Khác',
            default => 'Không xác định',
        };
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

        // Level 2 (Cơ quan/Phân xưởng) can only view if they have permission or document is public
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

        // Level 2 (Cơ quan/Phân xưởng) can only download if they have permission or document is public
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
