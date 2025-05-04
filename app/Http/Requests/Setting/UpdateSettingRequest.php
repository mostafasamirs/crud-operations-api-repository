<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust authorization logic as needed
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            '*.id' => 'required|integer|exists:settings,id',
            '*.key' => 'required|string',
            '*.field_type' => 'required|string',
            '*.is_translatable' => ['required', function ($attribute, $value, $fail) {
                if (!is_bool($value) && !in_array($value, ['true', 'false', 1, 0, '1', '0'], true)) {
                    $fail('The ' . $attribute . ' field must be a boolean.');
                }
            }],
            '*.plain_value' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            '*.id.required' => __('api::setting.id_required'),
            '*.id.integer' => __('api::setting.id_integer'),
            '*.id.exists' => __('api::setting.id_exists'),
            '*.key.required' => __('api::setting.key_required'),
            '*.key.string' => __('api::setting.key_string'),
            '*.field_type.required' => __('api::setting.field_type_required'),
            '*.field_type.string' => __('api::setting.field_type_string'),
            '*.is_translatable.required' => __('api::setting.is_translatable_required'),
            '*.plain_value.required' => __('api::setting.plain_value_required'),
            '*.plain_value.string' => __('api::setting.plain_value_string'),
        ];
    }

}
