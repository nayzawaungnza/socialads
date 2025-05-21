<?php

namespace App\Http\Requests\ConfigSetting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConfigSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'site_name' => ['nullable', 'string', 'max:255'],
            'site_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,svg', 'max:2048'],
            'favicon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,svg', 'max:512'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'facebook_url' => ['nullable', 'url'],
            'twitter_url' => ['nullable', 'url'],
            'youtube_url' => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'linkedin_url' => ['nullable', 'url'],
            'tiktok_url' => ['nullable', 'url'],
            'whatsapp_url' => ['nullable'],
            'viber' => ['nullable'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'copyright_text' => ['nullable', 'string', 'max:255'],
            'timezone' => ['nullable', 'string', 'timezone'],
            'maintenance_mode' => ['nullable', 'in:1,0'],
            'google_maps_api_key' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'google_maps_embed_url' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'site_logo.image' => 'The site logo must be an image.',
            'favicon.image' => 'The favicon must be an image.',
            'site_logo.mimes' => 'The site logo must be a file of type: jpg, jpeg, png, gif, svg.',
            'favicon.mimes' => 'The favicon must be a file of type: jpg, jpeg, png, gif, svg.',
            'site_logo.max' => 'The site logo may not be greater than 2MB.',
            'favicon.max' => 'The favicon may not be greater than 512KB.',
            'contact_email.email' => 'The contact email must be a valid email address.',
            'contact_email.max' => 'The contact email may not be greater than 255 characters.',
            'contact_phone.max' => 'The contact phone may not be greater than 20 characters.',
            'address.max' => 'The address may not be greater than 500 characters.',
            'meta_description.max' => 'The meta description may not be greater than 500 characters.',
            'meta_keywords.max' => 'The meta keywords may not be greater than 255 characters.',
            'copyright_text.max' => 'The copyright text may not be greater than 255 characters.',
            'google_maps_api_key.max' => 'The google maps api key may not be greater than 255 characters.',
            'latitude.between' => 'The latitude must be between -90 and 90.',
            'longitude.between' => 'The longitude must be between -180 and 180.',
            'google_maps_embed_url.url' => 'The google maps embed url must be a valid url.',
            'google_maps_embed_url.max' => 'The google maps embed url may not be greater than 255 characters.',
            'timezone.timezone' => 'The timezone must be a valid timezone.',
            'timezone.max' => 'The timezone may not be greater than 255 characters.',
            'facebook_url.url' => 'The facebook url must be a valid url.',
            'twitter_url.url' => 'The twitter url must be a valid url.',
            'youtube_url.url' => 'The youtube url must be a valid url.',
            'instagram_url.url' => 'The instagram url must be a valid url.',
            'linkedin_url.url' => 'The linkedin url must be a valid url.',
        ];  
    }
}