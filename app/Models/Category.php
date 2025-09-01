<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren');
    }

    public function getFullNameAttribute(): string
    {
        $names = [$this->name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($names, $parent->name);
            $parent = $parent->parent;
        }

        return implode(' > ', $names);
    }

    public function getDepthAttribute(): int
    {
        $depth = 0;
        $parent = $this->parent;

        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }

        return $depth;
    }

    public function getDocumentCountAttribute(): int
    {
        return $this->documents()->count();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public static function getTree()
    {
        return static::with('allChildren')
            ->roots()
            ->active()
            ->ordered()
            ->get();
    }

    public static function getFlatList()
    {
        return static::active()
            ->with('parent')
            ->ordered()
            ->get()
            ->map(function ($category) {
                $prefix = str_repeat('— ', $category->depth);
                return [
                    'id' => $category->id,
                    'name' => $prefix . $category->name,
                    'full_name' => $category->full_name,
                    'depth' => $category->depth,
                ];
            });
    }

    public function getAllParents(): array
    {
        $parents = [];
        $parent = $this->parent;
        
        while ($parent) {
            array_unshift($parents, $parent);
            $parent = $parent->parent;
        }
        
        return $parents;
    }

    public function getAllDescendants()
    {
        $descendants = collect();
        
        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->getAllDescendants());
        }
        
        return $descendants;
    }

    public function getTotalDocumentCountAttribute(): int
    {
        $count = $this->documents()->count();
        
        foreach ($this->children as $child) {
            $count += $child->total_document_count;
        }
        
        return $count;
    }

    public function getIndentedNameAttribute(): string
    {
        return str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $this->depth) . $this->name;
    }

    public static function getTreeStructure($maxDepth = 4)
    {
        return static::with(['allChildren' => function ($query) use ($maxDepth) {
            $query->where(function ($q) use ($maxDepth) {
                // Limit depth to prevent infinite recursion
                for ($i = 0; $i < $maxDepth; $i++) {
                    $q->orWhereRaw("(SELECT COUNT(*) FROM categories c WHERE c.id = categories.parent_id) <= ?", [$i]);
                }
            });
        }])
        ->roots()
        ->active()
        ->ordered()
        ->get();
    }
}