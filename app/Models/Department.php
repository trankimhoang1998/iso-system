<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Get all departments for dropdowns
    public static function getList()
    {
        return static::orderBy('name')
            ->pluck('name', 'id');
    }
}