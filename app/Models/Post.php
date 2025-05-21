<?php

namespace App\Models;

use App\Models\Image;
use App\Traits\Uuids;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Events\PostPublishedEvent;

class Post extends Model
{
    use HasFactory, Uuids, SoftDeletes, HasSlug;

    protected $fillable = [
        'post_category_id',
        'name',
        'slug',
        'description',
        'excerpt',
        'status',
        'is_featured',
        'created_by',
        'updated_by'
    ];
    protected $casts = [
        'status' => 'boolean',
        'is_featured' => 'boolean'
    ];
    
    protected static function booted()
    {
        static::updated(function ($post) {
            if ($post->isDirty('status') && $post->status === 1) {
                event(new PostPublishedEvent($post));
            }
        });
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->description));
        $readTime = ceil($wordCount / 200);
        return $readTime . ' ' . ($readTime == 1 ? 'min read' : 'mins read');
    }
    
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name']) // Generate slug from multiple fields
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
            ->doNotGenerateSlugsOnUpdate() // Limit the length of the slug
            ->usingSeparator('-'); // Use underscore as separator
    }

    public function postCategories()
    {
        return $this->belongsToMany(
            PostCategory::class,
            'post_category_post', // pivot table name
            'post_id',            // FK on pivot table for posts
            'post_category_id'    // FK on pivot table for post_categories
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