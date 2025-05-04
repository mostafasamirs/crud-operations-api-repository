<?php

namespace App\Http\Requests\SubPage;

use App\Enums\PagePositionEnum;
use App\Enums\PositionType;
use App\Enums\StatusType;
use App\Models\NewsArticle;
use App\Models\SubPage;
use App\Traits\UniqueSlugRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubPageRequest extends FormRequest
{
    use UniqueSlugRule;

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
            'is_active' => 'required|boolean',
            'image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'position' => ['required', Rule::enum(PagePositionEnum::class)],
            'slug' => [
                'required',
                'max:100',
                Rule::unique('sub_pages', 'slug')->whereNull('deleted_at')->ignore($this->uuid, 'uuid'),
            ],
            'translations' => 'required|array',
            'translations.*.locale' => 'required',
            'translations.*.title' => 'required|string|max:100',
            'translations.*.description' => 'required|string',
            'translations.*.meta_title' => 'nullable|string|max:50',
            'translations.*.meta_description' => 'nullable|string|max:255',
            'translations.*.meta_keywords' => 'nullable|string|max:255',
            'translations.*.meta_tags' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'is_active.required' => lang('api::subPage.is_active_required'),
//            'image.required' => lang('api::subPage.image_required'),
            'translations.*.description.max' => lang('api::subPage.description_max'),
            'image.required' =>lang('api::subPage.image_required'),
            'image.image' =>lang('api::subPage.image_image'),
            'image.mimes' =>lang('api::subPage.image_mimes'),
            'image.max' =>lang('api::subPage.image_max'),

            'position.required' => lang('api::subPage.position_required'),
            'position' => lang('api::subPage.position_invalid'),

            'translations.required' => lang('api::subPage.translations_required'),
            'translations.array' => lang('api::subPage.translations_must_be_array'),

            'translations.*.locale.required' => lang('api::subPage.locale_required'),

            'translations.*.title.required' => lang('api::subPage.title_required'),
            'translations.*.title.string' => lang('api::subPage.title_must_be_string'),
            'translations.*.title.max' => lang('api::subPage.title_max_length'),

            'translations.*.slug.required' => lang('api::subPage.slug_required'),
            'translations.*.slug.string' => lang('api::subPage.slug_must_be_string'),
            'translations.*.slug.unique' => lang('api::subPage.slug_already_taken'),
            'translations.*.slug.max' => lang('api::subPage.slug_max_length'),

            'translations.*.description.required' => lang('api::subPage.description_required'),
            'translations.*.description.string' => lang('api::subPage.description_must_be_string'),

            'translations.*.meta_title.string' => lang('api::subPage.meta_title_must_be_string'),
            'translations.*.meta_title.max' => lang('api::subPage.meta_title_max_length'),

            'translations.*.meta_description.string' => lang('api::subPage.meta_description_must_be_string'),
            'translations.*.meta_description.max' => lang('api::subPage.meta_description_max_length'),

            'translations.*.meta_keywords.string' => lang('api::subPage.meta_keywords_must_be_string'),
            'translations.*.meta_keywords.max' => lang('api::subPage.meta_keywords_max_length'),

            'translations.*.meta_tags.string' => lang('api::subPage.meta_tags_must_be_string'),
            'translations.*.meta_tags.max' => lang('api::subPage.meta_tags_max_length'),

        ];
    }
}

