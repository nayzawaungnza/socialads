<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiceRequest extends FormRequest
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
            'sub_title' => 'nullable|string',
            'sub_description' => 'nullable|string',
                'brand_title' => 'nullable|string',
                'brand_description' => 'nullable|string',
                'business_title' => 'nullable|string',
                'personalization_title' => 'nullable|string',
                'personalization_description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.max' => 'Name is too long',
            
        ];
    }
}