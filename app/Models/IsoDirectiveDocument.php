<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IsoDirectiveDocument extends Model
{
    protected $fillable = [
        'category_id',
        'pdf_file_name',
        'pdf_file_path',
        'pdf_file_type',
        'pdf_file_size',
        'word_file_name',
        'word_file_path',
        'word_file_type',
        'word_file_size',
        'issued_date',
        'document_number',
        'issuing_agency',
        'summary',
        'uploaded_by',
    ];

    protected $casts = [
        'issued_date' => 'date',
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
     * Get PDF file size in human readable format
     */
    public function getFormattedPdfFileSize(): string
    {
        return $this->formatFileSize($this->pdf_file_size);
    }

    /**
     * Get Word file size in human readable format
     */
    public function getFormattedWordFileSize(): string
    {
        return $this->formatFileSize($this->word_file_size);
    }

    /**
     * Get file size in human readable format (backward compatibility)
     */
    public function getFormattedFileSize(): string
    {
        return $this->getFormattedPdfFileSize();
    }

    /**
     * Format file size helper method
     */
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

    /**
     * Check if document has PDF file
     */
    public function hasPdfFile(): bool
    {
        return !empty($this->pdf_file_path);
    }

    /**
     * Check if document has Word file
     */
    public function hasWordFile(): bool
    {
        return !empty($this->word_file_path);
    }

    /**
     * Get file path for backward compatibility
     */
    public function getFilePathAttribute()
    {
        return $this->pdf_file_path;
    }

    /**
     * Get file name for backward compatibility
     */
    public function getFileNameAttribute()
    {
        return $this->pdf_file_name;
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