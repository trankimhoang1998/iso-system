<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewProcess extends Model
{
    protected $fillable = [
        'title',
        'issue_date',
        'document_link',
        'display_order'
    ];

    protected $casts = [
        'issue_date' => 'date'
    ];
}
