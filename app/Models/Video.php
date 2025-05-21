<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'resourceable_type',
        'resourceable_id',
        'video_url',
        'image_url',
        'is_default',
        'frame',
        'code',
        'mime_type',
        'size',
    ];

    public function resourceable()
    {
        return $this->MorphTo();
        
    }
}