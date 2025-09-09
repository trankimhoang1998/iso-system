<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IsoSystemCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'parent_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(IsoSystemCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(IsoSystemCategory::class, 'parent_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(IsoSystemDocument::class, 'category_id');
    }

    public static function getFlatList()
    {
        $categories = self::with('children.children.children')
            ->whereNull('parent_id')
            ->orderBy('id')
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