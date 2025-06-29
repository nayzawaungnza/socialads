<?php

namespace App\Models;

use App\Traits\Uuids;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, Uuids, SoftDeletes, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'excerpt',
        'status',
        'created_by',
        'updated_by',
        'client_id',
        'stage',
        'date',
        'duration',
        'goal', 'strategy', 'result','industry'
        ];
    protected $casts = [
        'status' => 'boolean',
        'stage' => 'integer',
        'duration' => 'integer',
        'date' => 'date'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
public function categories()
    {
        return $this->belongsToMany(ProjectCategory::class, 'project_project_category');
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