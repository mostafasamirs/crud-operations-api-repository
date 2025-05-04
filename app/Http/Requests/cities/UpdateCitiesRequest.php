<?php

namespace App\Http\Requests\cities;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCitiesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'country_id' => 'required|numeric|exists:countries,id',
            'is_active' => 'nullable',
            'translations' => 'required|array',
            'translations.*.locale' => 'required|string|max:10',
            'translations.*.name' => 'required|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages()
    {
        return [
            'country_id.required' =>lang('api::city.country_id_required'),
            'country_id.numeric' =>lang('api::city.country_id_numeric'),
            'country_id.exists' =>lang('api::city.country_id_exists'),

            'translations.required' =>lang('api::city.translations_required'),
            'translations.array' =>lang('api::city.translations_array'),

            'translations.*.locale.required' =>lang('api::city.locale_required'),
            'translations.*.locale.string' =>lang('api::city.locale_string'),
            'translations.*.locale.max' =>lang('api::city.locale_max'),

            'translations.*.name.required' =>lang('api::city.name_required'),
            'translations.*.name.string' =>lang('api::city.name_string'),
            'translations.*.name.max' =>lang('api::city.name_max'),
        ];
    }
}
