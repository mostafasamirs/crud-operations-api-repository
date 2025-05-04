<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OTPRequest extends FormRequest
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
            'otp' => 'required',
            'email' => 'required|email|exists:authenticatable_otps,email'
        ];
    }

    public function messages()
    {
        return [
            'otp.required' => lang('api::auth.otp_required'),
            'email.required' => lang('api::auth.email_required'),
            'email.email' => lang('api::auth.email_invalid'),
            'email.exists' => lang('api::auth.email_not_found'),
        ];
    }
}
