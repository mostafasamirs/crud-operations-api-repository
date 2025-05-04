<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
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
            //            'code' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed', Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => lang('api::auth.email_required'),
            'email.email' => lang('api::auth.email_invalid'),
            'password.required' => lang('api::auth.password_required'),
            'password.min' => lang('api::auth.password_min'),
            'password.max' => lang('api::auth.password_max'),
            'password.confirmed' => lang('api::auth.password_confirmed'),
        ];
    }
}
