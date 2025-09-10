<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'issue_date',
        'document_link',
        'display_order',
    ];

    protected $casts = [
        'issue_date' => 'date',
    ];
}
