<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternalDocument extends Model
{
    protected $fillable = [
        'issued_date',
        'document_number',
        'issuing_agency',
        'summary',
        'category_id',
        'department_id',
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
    ];


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
        // Admin can view all documents
        if ($user->role == User::ROLE_ADMIN) {
            return true;
        }

        // Level 1 (Ban ISO) can view all documents they uploaded
        if ($user->role == User::ROLE_LEVEL1) {
            return $this->uploaded_by == $user->id;
        }

        // Level 2 and Level 3 users cannot view documents by default
        return false;
    }

    public function canUserDownload(User $user): bool
    {
        return $this->canUserView($user);
    }
}
