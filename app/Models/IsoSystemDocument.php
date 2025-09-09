<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class IsoSystemDocument extends Model
{
    protected $fillable = [
        'category_id',
        'symbol',
        'title',
        'issued_date',
        'latest_update',
        'pdf_file_name',
        'pdf_file_path',
        'pdf_file_type',
        'pdf_file_size',
        'word_file_name',
        'word_file_path',
        'word_file_type',
        'word_file_size',
        'uploaded_by',
        'display_order',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'latest_update' => 'date',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(IsoSystemCategory::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'iso_system_document_department');
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

    public function canUserDownload(User $user): bool
    {
        return $this->canUserView($user);
    }
}
