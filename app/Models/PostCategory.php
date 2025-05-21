<?php

namespace App\Models;

use App\Traits\Uuids;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostCategory extends Model
{
    use HasFactory, Uuids, SoftDeletes, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'status',
        'topics',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => 'boolean',
        'topics' => 'boolean',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name']) // Generate slug from multiple fields
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
            ->doNotGenerateSlugsOnUpdate() // Limit the length of the slug
            ->usingSeparator('-'); // Use underscore as separator
    }

    public function parent()
    {
        return $this->belongsTo(PostCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(PostCategory::class, 'parent_id');
    }

    public function posts()
    {
        return $this->belongsToMany(
            Post::class,
            'post_category_post', // pivot table name
            'post_category_id',   // FK on pivot table for post_categories
            'post_id'             // FK on pivot table for posts
        );
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public function images()
    {
        return $this->morphMany(Image::class, 'resourceable', 'resourceable_type', 'resourceable_id');
    }

    public function default_image()
    {
        return $this->morphOne(Image::class, 'resourceable', 'resourceable_type', 'resourceable_id')
            ->where('is_default', config('constants.STATUS_TRUE'));
    }

}