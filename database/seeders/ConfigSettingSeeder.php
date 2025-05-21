<?php

namespace Database\Seeders;

use App\Models\ConfigSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigSetting::create([
            'site_name' => 'Venom Hub',
            'site_logo' => '',
            'favicon' => '',
            'contact_email' => '',
            'contact_phone' => '',
            'address' => '',
            'facebook_url' => '',
            'twitter_url' => '',
            'instagram_url' => '',
            'linkedin_url' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'copyright_text' => '',
            'timezone' => 'Asia/Myanmar',
            'maintenance_mode' => 0,
            'google_maps_api_key' => '', // Google Maps API key
            'latitude' => 0, // Latitude
            'longitude' => 0, // Longitude
            'google_maps_embed_url' => '', // Embedded Google Maps URL
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}