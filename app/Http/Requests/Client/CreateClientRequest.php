<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'url' => 'nullable|url',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'facebook' => 'nullable|url',
            'telegram' => 'nullable|url',
            'youtube' => 'nullable|url',
            'linkedIn' => 'nullable|url',
            'twitter' => 'nullable|url',
            'tiktok' => 'nullable|url',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.max' => 'Name is too long',
            'url.url' => 'Button URL must be a valid URL',
            'facebook.url' => 'Facebook URL must be a valid URL',
            'telegram.url' => 'Telegram URL must be a valid URL',
            'youtube.url' => 'Youtube URL must be a valid URL',
            'linkedIn.url' => 'LinkedIn URL must be a valid URL',
            'twitter.url' => 'Twitter URL must be a valid URL',
            'tiktok.url' => 'Tiktok URL must be a valid URL',
        ];
    }
}