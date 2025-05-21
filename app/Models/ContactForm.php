<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ContactForm extends Model
{
    use HasFactory, Uuids, SoftDeletes;
    
     protected $fillable = [
        'name', 'email', 'phone', 'subject', 'type', 'message', 'status', 'mark_as_read', 'updated_by', 'favourite', 'archive', 'trash', 'company_name',
'service_id'
    ];
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function service() {
        return $this->belongsTo(Service::class, 'service_id');
    }
    
    public function getFormattedCreatedAtAttribute()
    {
        $createdAt = Carbon::parse($this->created_at);

        // Check if the date is today, yesterday, or a specific date
        if ($createdAt->isToday()) {
            return 'Today, ' . $createdAt->format('g:i A');
        } elseif ($createdAt->isYesterday()) {
            return 'Yesterday, ' . $createdAt->format('g:i A');
        } else {
            return $createdAt->format('j F Y, g:i A');
        }
    }
}
