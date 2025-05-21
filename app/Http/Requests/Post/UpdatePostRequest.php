<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'post_category' => 'required|array',
            'post_category.*' => 'exists:post_categories,id',
            'is_featured' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.max' => 'Name is too long',
            'post_category.required'   => 'Post category is required',
            'post_category.array'      => 'Post category must be an array',
            'post_category.*.exists'   => 'One or more selected post categories do not exist',
        ];
    }
}