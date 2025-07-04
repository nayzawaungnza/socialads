<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
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
            'name' => 'required|max:' . config('constants.STRING_DEFAULT_MAX_LENGTH') . '|unique:roles,name',
            'guard_name' => 'required',
            'permission' => 'required',
            'permission.*' => 'integer|exists:permissions,id',
        ];
    }
}