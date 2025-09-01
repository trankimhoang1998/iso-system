<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IsoDirectiveDocument extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'status',
        'uploaded_by',
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
        return $this->belongsTo(IsoDirectiveCategory::class);
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
     * Check if user has permission to view document
     */
    public function canUserView(User $user): bool
    {
        // Admin can view all documents
        if ($user->role == User::ROLE_ADMIN) {
            return true;
        }

        // Level 1 (Ban ISO) can view all documents they uploaded
        if ($user->role == User::ROLE_LEVEL1) {
            return $this->uploaded_by == $user->id;
        }

        // Level 2 and Level 3 users cannot view documents by default
        // (You may need to adjust this logic based on your requirements)
        return false;
    }

    /**
     * Check if user has permission to download document
     */
    public function canUserDownload(User $user): bool
    {
        return $this->canUserView($user);
    }
}