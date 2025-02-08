<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use HasFactory, SoftDeletes; 

    protected $dates = ['deleted_at']; 
    protected $table  = 'subcategories';
    protected $fillable = [
        'name',
        'title',
        'slug',
        'meta_title',
        'description',
        'meta_description',
        'image',
        'color',
        'sort_order',
        'category_id',
        'is_featured',
        'is_active',
        'published_at',
        'seo_keywords',
        'visibility',
        'view_count',
        'author',
        'language',
        'allow_comments',
        'additional_data',
    ];

    
    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id'); 
    }

    
    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at ? $this->published_at->format('F j, Y') : 'Not Published';
    }

    public function getVisibilityAttribute($value)
    {
        return ucfirst($value);
    }
}
