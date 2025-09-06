<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagementDocument extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'pdf_file_name',
        'pdf_file_path',
        'pdf_file_type',
        'pdf_file_size',
        'word_file_name',
        'word_file_path',
        'word_file_type',
        'word_file_size',
        'status',
        'symbol',
        'issued_year',
        'document_number',
        'issuing_agency',
        'summary',
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
        return $this->belongsTo(ManagementDocumentCategory::class);
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

    public function getFormattedPdfFileSize(): string
    {
        return $this->formatFileSize($this->pdf_file_size);
    }

    public function getFormattedWordFileSize(): string
    {
        return $this->formatFileSize($this->word_file_size);
    }

    public function getFormattedFileSize(): string
    {
        return $this->getFormattedPdfFileSize();
    }

    private function formatFileSize(?int $bytes): string
    {
        if (!$bytes) {
            return '0 bytes';
        }
        
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function hasPdfFile(): bool
    {
        return !empty($this->pdf_file_path);
    }

    public function hasWordFile(): bool
    {
        return !empty($this->word_file_path);
    }

    public function getFilePathAttribute()
    {
        return $this->pdf_file_path;
    }

    public function getFileNameAttribute()
    {
        return $this->pdf_file_name;
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
