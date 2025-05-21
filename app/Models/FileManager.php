<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileManager extends Model
{
    use HasFactory,Uuids,SoftDeletes;

    protected $fillable = [
        'resourceable_type',
        'resourceable_id',
        'file_name',
        'file_url',
        'file_type',
        'is_default',
    ];

    public function resourceable()
    {
        return $this->MorphTo();
    }

    public function getUrl()
    {
        return Storage::url($this->file_url);
    }
}