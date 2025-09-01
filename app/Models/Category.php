<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'document_type_id',
        'parent_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function scopeByDocumentType($query, $documentTypeId)
    {
        return $query->where('document_type_id', $documentTypeId);
    }

    public static function getFlatList()
    {
        $categories = self::with('children.children.children')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        $result = [];
        
        foreach ($categories as $category) {
            self::addCategoryToFlatList($result, $category, 0);
        }
        
        return $result;
    }

    private static function addCategoryToFlatList(&$list, $category, $level)
    {
        $list[] = [
            'id' => $category->id,
            'name' => str_repeat('— ', $level) . $category->name,
            'level' => $level
        ];
        
        foreach ($category->children as $child) {
            self::addCategoryToFlatList($list, $child, $level + 1);
        }
    }
}