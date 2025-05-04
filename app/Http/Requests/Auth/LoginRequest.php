<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'email' => ['required', 'email', Rule::exists('admins', 'email')],
            'password' => ['required', 'min:8', 'max:100']
        ];
    }

    public function messages()
    {
        return [
            'email.required' =>lang('api::auth.email_required'),
            'email.email' =>lang('api::auth.email_invalid'),
            'email.exists' =>lang('api::auth.email_not_found'),
            'password.required' =>lang('api::auth.password_required'),
            'password.min' =>lang('api::auth.password_min'),
            'password.max' =>lang('api::auth.password_max'),
        ];
    }
}
