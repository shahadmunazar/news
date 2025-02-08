<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsCategory extends Model
{
    use SoftDeletes;
    protected $table = 'news_categories';
    protected $fillable = [
        'name',
        'title',
        'slug',
        'meta_title',
        'description',
        'meta_description',
        'image',
        'icon',
        'color',
        'sort_order',
        'parent_id',
        'is_featured',
        'is_active',
        'published_at',
        'seo_keywords',
        'visibility',
        'view_count',
        'author',
        'language',
        'allow_comments',
        'additional_data'
    ];

    /**
     * Parent Category Relationship.
     */
    public function parent()
    {
        return $this->belongsTo(NewsCategory::class, 'parent_id');
    }

    /**
     * Child Categories Relationship.
     */
    public function children()
    {
        return $this->hasMany(NewsCategory::class, 'parent_id');
    }

    /**
     * Scope to fetch only active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
