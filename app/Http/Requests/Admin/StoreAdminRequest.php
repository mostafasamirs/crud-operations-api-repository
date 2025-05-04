<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'nullable',
            'mobile'=> 'required|unique:admins,mobile|numeric|length:11',
            'identity'=> 'nullable|unique:admins,identity|max:14',
            'email'=> 'required|unique:admins,email',
            'password'=> 'required|min:8',
            'confirm_password'=> 'required|same:password',
            'role'=>'required',
            'address'=> 'nullable',
            'nationality_id'=> 'nullable',
            'country_id'=> 'nullable|exists:countries,id',
            'translations' => 'required|array',
            'translations.*.locale' => 'required',
            'translations.*.first_name' => 'required|string|min:2|max:255',
            'translations.*.second_name' => 'required|string|min:2|max:255',
            'translations.*.third_name' => 'required|string|min:2|max:255',
            'translations.*.last_name' => 'required|string|min:2|max:255',
        ];
    }

    public function messages()
    {
        return [
            'image.image' => lang('api::admin.image_invalid'),
            'image.mimes' => lang('api::admin.image_invalid_mimes'),
            'image.max' => lang('api::admin.image_max_size'),


            'mobile.required' => lang('api::admin.mobile_required'),
            'mobile.unique' => lang('api::admin.mobile_unique'),
            'mobile.numeric' => lang('api::admin.mobile_numeric'),
            'mobile.length' => lang('api::admin.mobile_length'),

            'identity.unique' => lang('api::admin.identity_unique'),
            'identity.max' => lang('api::admin.identity_max'),

            'email.required' => lang('api::admin.email_required'),
            'email.unique' => lang('api::admin.email_unique'),

            'password.required' => lang('api::admin.password_required'),
            'password.min' => lang('api::admin.password_min'),

            'confirm_password.required' => lang('api::admin.confirm_password_required'),
            'confirm_password.same' => lang('api::admin.confirm_password_same'),

            'role.required' => lang('api::admin.role_required'),

            'country_id.exists' => lang('api::admin.country_id_exists'),

            'translations.required' => lang('api::admin.translations_required'),
            'translations.array' => lang('api::admin.translations_array'),

            'translations.*.locale.required' => lang('api::admin.locale_required'),

            'translations.*.first_name.required' => lang('api::admin.first_name_required'),
            'translations.*.first_name.string' => lang('api::admin.first_name_string'),
            'translations.*.first_name.min' => lang('api::admin.first_name_min'),
            'translations.*.first_name.max' => lang('api::admin.first_name_max'),

            'translations.*.second_name.required' => lang('api::admin.second_name_required'),
            'translations.*.second_name.string' => lang('api::admin.second_name_string'),
            'translations.*.second_name.min' => lang('api::admin.second_name_min'),
            'translations.*.second_name.max' => lang('api::admin.second_name_max'),

            'translations.*.third_name.required' => lang('api::admin.third_name_required'),
            'translations.*.third_name.string' => lang('api::admin.third_name_string'),
            'translations.*.third_name.min' => lang('api::admin.third_name_min'),
            'translations.*.third_name.max' => lang('api::admin.third_name_max'),

            'translations.*.last_name.required' => lang('api::admin.last_name_required'),
            'translations.*.last_name.string' => lang('api::admin.last_name_string'),
            'translations.*.last_name.min' => lang('api::admin.last_name_min'),
            'translations.*.last_name.max' => lang('api::admin.last_name_max'),
        ];
    }
}
