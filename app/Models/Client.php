<?php

namespace App\Models;

use App\Traits\Uuids;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory, Uuids, SoftDeletes, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'company',
        'url',
        'status',
        'description',
        'excerpt',
        'socials',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'socials' => 'array', // Automatically converts JSON to array
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