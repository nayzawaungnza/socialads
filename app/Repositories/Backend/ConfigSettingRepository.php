<?php

namespace App\Repositories\Backend;

use App\Models\ConfigSetting;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ConfigSettingRepository extends BaseRepository
{
    private $config_setting_instance;

    /**
     * @return string
     */
    public function model()
    {
        return ConfigSetting::class;
    }

    /**
     * Get system configuration setting.
     * 
     * @return ConfigSetting
     */
    public function getSettings()
    {
        return ConfigSetting::first();
    }

    /**
     * Update config setting.
     *
     * @param ConfigSetting $config_setting
     * @param array $data
     * @return ConfigSetting $config_setting
     */
    public function update(ConfigSetting $config_setting, array $data)
    {
        $config_setting->fill([
            'site_name' => $data['site_name'] ?? $config_setting->site_name,
            'contact_email' => $data['contact_email'] ?? $config_setting->contact_email,
            'contact_phone' => $data['contact_phone'] ?? $config_setting->contact_phone,
            'address' => $data['address'] ?? $config_setting->address,
            'facebook_url' => $data['facebook_url'] ?? $config_setting->facebook_url,
            'twitter_url' => $data['twitter_url'] ?? $config_setting->twitter_url,
            'youtube_url' => $data['youtube_url'] ?? $config_setting->youtube_url,
            'instagram_url' => $data['instagram_url'] ?? $config_setting->instagram_url,
            'linkedin_url' => $data['linkedin_url'] ?? $config_setting->linkedin_url,
            'tiktok_url' => $data['tiktok_url'] ?? $config_setting->tiktok_url,
            'whatsapp_url' => $data['whatsapp_url'] ?? $config_setting->whatsapp_url,
            'viber' => $data['viber'] ?? $config_setting->viber,
            'meta_description' => $data['meta_description'] ?? $config_setting->meta_description,
            'meta_keywords' => $data['meta_keywords'] ?? $config_setting->meta_keywords,
            'copyright_text' => $data['copyright_text'] ?? $config_setting->copyright_text,
            'timezone' => $data['timezone'] ?? $config_setting->timezone,
            'maintenance_mode' => $data['maintenance_mode'] ?? $config_setting->maintenance_mode,
            'google_maps_api_key' => $data['google_maps_api_key'] ?? $config_setting->google_maps_api_key,
            'latitude' => $data['latitude'] ?? $config_setting->latitude,
            'longitude' => $data['longitude'] ?? $config_setting->longitude,
            'google_maps_embed_url' => $data['google_maps_embed_url'] ?? $config_setting->google_maps_embed_url,
        ]);
    
        $path_name = "settings";
    
        if (isset($data['site_logo']) && $data['site_logo']) {
            // Define file name
            $fileName = 'site_logo_' . time() . '.' . $data['site_logo']->getClientOriginalExtension();
            
            // Store the file in storage/public/settings/
            Storage::disk('public')->put("{$path_name}/{$fileName}", file_get_contents($data['site_logo']));
    
            // Save path in database
            $config_setting->site_logo = "{$path_name}/{$fileName}";
        }
    
        if (isset($data['favicon']) && $data['favicon']) {
            // Define file name
            $fileName = 'favicon_' . time() . '.' . $data['favicon']->getClientOriginalExtension();
            
            // Store the file in storage/public/settings/
            Storage::disk('public')->put("{$path_name}/{$fileName}", file_get_contents($data['favicon']));
    
            // Save path in database
            $config_setting->favicon = "{$path_name}/{$fileName}";
        }
    

        if ($config_setting->isDirty()) {
            $config_setting->save();
            // save activity in activitylog
            $activity_data['subject'] = $config_setting->refresh();
            $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
            $activity_data['description'] = sprintf('Admin(%s) updated config setting.', auth()->user()->name);
            saveActivityLog($activity_data);
        }

        return $config_setting;
    }

    /**
     * Get system configuration setting by setting name.
     * 
     * @param string $setting_name
     * @return int
     */
    public function getSetting(string $setting_name)
    {
        if (!$this->config_setting_instance) {
            $this->config_setting_instance = ConfigSetting::first();
        }
        return $this->config_setting_instance?->$setting_name;
    }
}