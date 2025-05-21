<?php

namespace App\Http\Requests\ContactForm;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    
    protected function prepareForValidation()
    {
        if (!$this->filled('name')) {
            $fullName = trim($this->input('first_name') . ' ' . $this->input('last_name'));
            $this->merge([
                'name' => $fullName
            ]);
        }
        if (!$this->filled('subject')) {
            $defaultSubject = 'General Inquiry';

            // Append company name if provided
            if ($this->filled('company_name')) {
                $defaultSubject .= ' - ' . $this->input('company_name');
            }

            $this->merge([
                'subject' => $defaultSubject
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone_number'  => 'nullable|string|max:20',
            'subject'       => 'required|string|max:255',
            'message'       => 'required|string',
            'company_name'  => 'nullable|string|max:255',
            'service_id'    => 'nullable|exists:services,id',
            'subscribe'     => 'nullable|boolean'
        ];
    }
    public function messages(): array
    {
        return [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'message.required' => 'Please tell us about your project.',
        ];
    }
}