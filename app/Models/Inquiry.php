<?php

namespace App\Models;

use App\Traits\Uuids;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
    use HasFactory, Notifiable, HasRoles, Uuids, SoftDeletes;
    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'status'];
}