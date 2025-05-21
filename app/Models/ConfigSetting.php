<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConfigSetting extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'site_name',
        'site_logo',
        'favicon',
        'contact_email',
        'contact_phone',
        'address',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'youtube_url',
        'linkedin_url',
        'tiktok_url',
        'whatsapp_url',
        'viber',
        'meta_description',
        'meta_keywords',
        'copyright_text',
        'timezone',
        'maintenance_mode',
        'google_maps_api_key', // Google Maps API key
        'latitude', // Latitude
        'longitude', // Longitude
        'google_maps_embed_url', // Embedded Google Maps URL
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean', // Cast to boolean
        
    ];
}