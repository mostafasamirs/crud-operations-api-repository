<?php

namespace App\Http\Requests\Countries;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountriesRequest extends FormRequest
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
            'code' => 'nullable|numeric',
            'is_active' => 'nullable',
            'is_default' => 'nullable',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'translations' => 'nullable|array',
            'translations.*.locale' => 'required|string|max:10',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.nationality' => 'nullable|string|max:255',
            'translations.*.default_currency' => 'nullable|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'code.required' => 'The code field is required.',
            'code.string' => 'The code field must be a string.',
            'is_active.required' => 'The status field is required.',
            'is_active.boolean' => 'The status field must be a boolean (yes/no).',

            'is_default.required' => 'The default field is required.',
            'is_default.boolean' => 'The default field must be a boolean (yes/no).',

            'code.max' => lang('api::country.code_max'),

            'flag.image' => lang('api::country.flag_image'),
            'flag.mimes' => lang('api::country.flag_mimes'),
            'flag.max' => lang('api::country.flag_max'),

            'translations.required' => lang('api::country.translations_required'),
            'translations.array' => lang('api::country.translations_array'),

            'translations.*.locale.required' => lang('api::country.locale_required'),
            'translations.*.locale.string' => lang('api::country.locale_string'),
            'translations.*.locale.max' => lang('api::country.locale_max'),

            'translations.*.name.required' => lang('api::country.name_required'),
            'translations.*.name.string' => lang('api::country.name_string'),
            'translations.*.name.max' => lang('api::country.name_max'),

            'translations.*.nationality.string' => lang('api::country.nationality_string'),
            'translations.*.nationality.max' => lang('api::country.nationality_max'),

            'translations.*.default_currency.string' => lang('api::country.default_currency_string'),
            'translations.*.default_currency.max' => lang('api::country.default_currency_max'),

        ];
    }
}
