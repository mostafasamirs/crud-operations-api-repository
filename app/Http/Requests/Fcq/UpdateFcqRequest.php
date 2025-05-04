<?php

namespace App\Http\Requests\Fcq;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFcqRequest extends FormRequest
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
            'is_active' => 'nullable',
            'translations' => 'required|array',
            'translations.*.locale' => 'required',
            'translations.*.question' => 'required|max:255',
            'translations.*.answer' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'is_active.required' => lang('api::faq.is_active_required'),
            'translations.required' => lang('api::faq.translations_required'),
            'translations.array' => lang('api::faq.translations_array'),
            'translations.*.locale.required' => lang('api::faq.locale_required'),
            'translations.*.question.required' => lang('api::faq.question_required'),
            'translations.*.question.max' => lang('api::faq.question_max'),
            'translations.*.answer.required' => lang('api::faq.answer_required'),

        ];
    }
}
