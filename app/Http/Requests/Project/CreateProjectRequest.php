<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
            'stage' => 'nullable|integer',
            'date' => 'nullable|date',
            'duration' => 'nullable|integer',
            'goal' => 'nullable|string', 
            'strategy' => 'nullable|string', 
            'result' => 'nullable|string',
            'industry' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.max' => 'Name is too long',
            'stage.integer' => 'Stage is not valid integer',
            'date.date' => 'Date is not valid',
            'duration.integer' => 'Duration is not valid integer',
        ];
    }
}