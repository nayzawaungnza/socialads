<?php

namespace App\Http\Requests\ProjectCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectCategoryRequest extends FormRequest
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
            'post_category' => 'required|exists:project_categories,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.max' => 'Name is too long',
            'post_category.required' => 'Post category is required',
            'post_category.exists' => 'Post category does not exist',
        ];
    }
}