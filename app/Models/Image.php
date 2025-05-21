<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\MorphTo;
class Image extends Model
{
    use HasFactory,Uuids,SoftDeletes;

    protected $fillable = [
        'resourceable_type',
        'resourceable_id',
        'image_url',
        'is_default',
    ];

    public function resourceable()
    {
        return $this->MorphTo();
        
    }

    // public function images()
    // {
    //     return $this->morphMany( Image::class, 'resourceable', 'resourceable_type', 'resourceable_id' );
    // }

    /**
     * Get s3 url attribute
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function getItemThumbnailS3UrlAttribute()
    {
        $folder = ($this->resourceable->is_gift) ? 'gift_items/' : 'items/';
        return ($this->image_url)
            ? Storage::disk('s3')->url(
                $folder . $this->resourceable->vendor->hub_vendor_id . '/' . $this->resourceable->vendor->code . '/' .
                    Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.THUMBNAIL'), $this->image_url)
            ) . '?v=' . time()
            : null;
    }

    protected function getItemSmallS3UrlAttribute()
    {
        $folder = ($this->resourceable->is_gift) ? 'gift_items/' : 'items/';
        return ($this->image_url)
            ? Storage::disk('s3')->url(
                $folder . $this->resourceable->vendor->hub_vendor_id . '/' . $this->resourceable->vendor->code . '/' .
                    Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.SMALL'), $this->image_url)
            ) . '?v=' . time()
            : null;
    }
    
    protected function getItemMediumS3UrlAttribute()
    {
        $folder = ($this->resourceable->is_gift) ? 'gift_items/' : 'items/';
        return ($this->image_url)
            ? Storage::disk('s3')->url(
                $folder . $this->resourceable->vendor->hub_vendor_id . '/' . $this->resourceable->vendor->code . '/' .
                    Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $this->image_url)
            ) . '?v=' . time()
            : null;
    }

    protected function getItemLargeS3UrlAttribute()
    {
        $folder = ($this->resourceable->is_gift) ? 'gift_items/' : 'items/';
        return ($this->image_url)
            ? Storage::disk('s3')->url(
                $folder . $this->resourceable->vendor->hub_vendor_id . '/' . $this->resourceable->vendor->code . '/' .
                    Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.LARGE'), $this->image_url)
            ) . '?v=' . time()
            : null;
    }

    protected function getTransactionMediumS3UrlAttribute()
    {
        return ($this->image_url)
            ? Storage::disk('s3')->url(
                'transactions/' . $this->image_url
            )
            : null;
    }

    protected function getCourseDefaultImageUrlAttribute( )
    {
        return ($this->image_url)
        ? Storage::disk('public')->url('courses/' . $this->image_url)
        : Storage::disk('public')->url(config('constants.DEFAULT_IMAGE'));
    }

    protected function getUserDefaultImageUrlAttribute( )
    {
        return ($this->image_url)
        ? Storage::disk('public')->url('users/' . $this->image_url)
        : null;
    }
}