<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8'
        ];
    }

     public function messages()
    {
        return [
            'name.required' => 'يجب تحديد الاسم',

            'email.required' => 'الايميل مطلوب',
            'email.unique' => 'يجب ان يكون الايميل فريداً',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'يجب ان تكون كلمة المرور 8 على الاقل'
        ];
    }
}
