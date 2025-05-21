<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:users,email',
            'mobile' => 'nullable|string|max:15|unique:users,mobile|regex:/^([0-9\s\-\+\(\)]*)$/|phone:MM',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'boolean|in:0,1|default:1',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.max' => 'Name is too long',
            'email.required' => 'Email is required',
            'email.max' => 'Email is too long',
            'email.unique' => 'Email already exists',
            'mobile.required' => 'Mobile is required',
            'mobile.max' => 'Mobile is too long',
            'mobile.unique' => 'Mobile already exists',
            'mobile.regex' => 'Mobile is not valid',
            'mobile.phone' => 'Mobile is not valid format(MM eg: 09xxxxxxxx)',
            'password.required' => 'Password is required',
            'password.min' => 'Password is too short, min is 8',
            'password.confirmed' => 'Password does not match',
        ];
    }
}