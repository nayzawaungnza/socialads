<?php

namespace App\Http\Requests\Faq;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqRequest extends FormRequest
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
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'service_id' => 'nullable|uuid|exists:services,id',
        ];
    }
    // Convert service_id to an array for the backend
    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        if (isset($data['service_id'])) {
            $data['service_ids'] = [$data['service_id']]; // Wrap in array
            unset($data['service_id']);
        }
        return $data;
    }
}
