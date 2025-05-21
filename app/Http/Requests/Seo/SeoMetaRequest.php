<?php

namespace App\Http\Requests\Seo;

use Illuminate\Foundation\Http\FormRequest;

class SeoMetaRequest extends FormRequest
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
         $rules = [
            'page_type' => 'required|string',
            'page_id' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'robots' => 'required|string',
        ];

        // Open Graph rules
        $rules['open_graph.title'] = 'nullable|string|max:255';
        $rules['open_graph.description'] = 'nullable|string';
        $rules['open_graph.image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        $rules['open_graph.url'] = 'nullable|url';

        // Twitter rules
        $rules['twitter.title'] = 'nullable|string|max:255';
        $rules['twitter.description'] = 'nullable|string';
        $rules['twitter.image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        $rules['twitter.url'] = 'nullable|url';

        // Structured Data rules
        $rules['structured_data.schema'] = 'nullable|string';
        $rules['structured_data.image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';

        // Alternate Links rules
        $rules['alternate_links.url'] = 'nullable|url';
        $rules['alternate_links.lang'] = 'nullable|string|max:10';

        return $rules;
    }
}
