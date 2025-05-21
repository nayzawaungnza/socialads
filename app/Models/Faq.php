<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, Uuids, SoftDeletes;
    
    protected $fillable = ['question', 'answer','created_by','updated_by','status'];
    
    public function services()
    {
        return $this->belongsToMany(Service::class, 'faq_service', 'faq_id', 'service_id');
    }
    
    
     public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
