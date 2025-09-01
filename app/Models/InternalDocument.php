<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternalDocument extends Model
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

    const STATUS_DRAFT = 'draft';
    const STATUS_APPROVED = 'approved';
    const STATUS_ARCHIVED = 'archived';

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(InternalDocumentCategory::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusName(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT => 'Bản nháp',
            self::STATUS_APPROVED => 'Đã phê duyệt',
            self::STATUS_ARCHIVED => 'Lưu trữ',
            default => 'Không xác định',
        };
    }

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

    public function canUserView(User $user): bool
    {
        if ($user->role == User::ROLE_ADMIN) {
            return true;
        }
        if ($user->role == User::ROLE_LEVEL1) {
            return $this->uploaded_by == $user->id || $this->is_public;
        }
        if ($user->role == User::ROLE_LEVEL2) {
            return $this->is_public;
        }
        if ($user->role == User::ROLE_LEVEL3) {
            return $this->is_public;
        }
        return false;
    }

    public function canUserDownload(User $user): bool
    {
        return $this->canUserView($user);
    }
}
