<?php

namespace App\Http\Requests\Slider;

use App\Models\NewsArticle;
use App\Models\Slider;
use App\Traits\UniqueSlugRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSliderRequest extends FormRequest
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
            'website_link' => 'nullable|url',
            'mobile_link' => 'nullable|url',
            'is_active' => 'nullable',
            'slug' => [
                'required',
                'max:100',
                Rule::unique('sliders', 'slug')->whereNull('deleted_at')->ignore($this->uuid, 'uuid'),
            ],
            'website_image' => 'nullable||image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'mobile_image' => 'nullable||image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'translations' => 'required|array',
            'translations.*.locale' => 'required|string|max:10',
            'translations.*.title' => 'required|string|max:50',
            'translations.*.description' => 'required|string|max:255',
            'translations.*.short_description' => 'required|string|max:100',
            'translations.*.meta_title' => 'nullable|string|max:255',
            'translations.*.meta_description' => 'nullable|string|max:255',
            'translations.*.meta_keywords' => 'nullable|string|max:255',
            'translations.*.meta_tags' => 'nullable|string|max:255',
        ];
    }

    /**
     * Define custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'website_image.file' => lang('api::slider.website_image_file'),

            'mobile_image.file' => lang('api::slider.mobile_image_file'),
            'is_active.required' => lang('api::slider.is_active_required'),

            'translations.*.slug.required' => lang('api::news.slug_required'),
            'translations.*.slug.unique' => lang('api::news.slug_unique'),
            'translations.*.meta_tags.string' => lang('api::news.meta_tags_must_be_a_string'),

            'website_link.url' =>lang('api::slider.website_link_url'),
            'mobile_link.url' =>lang('api::slider.mobile_link_url'),

            'website_image.required' =>lang('api::slider.website_image_required'),
            'website_image.image' =>lang('api::slider.website_image_image'),
            'website_image.mimes' =>lang('api::slider.website_image_mimes'),
            'website_image.max' =>lang('api::slider.website_image_max'),

            'mobile_image.required' =>lang('api::slider.mobile_image_required'),
            'mobile_image.image' =>lang('api::slider.mobile_image_image'),
            'mobile_image.mimes' =>lang('api::slider.mobile_image_mimes'),
            'mobile_image.max' =>lang('api::slider.mobile_image_max'),

            'translations.required' =>lang('api::slider.translations_required'),
            'translations.array' =>lang('api::slider.translations_array'),

            'translations.*.locale.required' =>lang('api::slider.locale_required'),
            'translations.*.locale.string' =>lang('api::slider.locale_string'),
            'translations.*.locale.max' =>lang('api::slider.locale_max'),

            'translations.*.title.required' =>lang('api::slider.title_required'),
            'translations.*.title.string' =>lang('api::slider.title_string'),
            'translations.*.title.max' =>lang('api::slider.title_max'),

            'translations.*.description.required' =>lang('api::slider.description_required'),
            'translations.*.description.string' =>lang('api::slider.description_string'),
            'translations.*.description.max' =>lang('api::slider.description_max'),

            'translations.*.short_description.required' =>lang('api::slider.short_description_required'),
            'translations.*.short_description.string' =>lang('api::slider.short_description_string'),
            'translations.*.short_description.max' =>lang('api::slider.short_description_max'),

            'translations.*.meta_title.string' =>lang('api::slider.meta_title_string'),
            'translations.*.meta_title.max' =>lang('api::slider.meta_title_max'),

            'translations.*.meta_description.string' =>lang('api::slider.meta_description_string'),
            'translations.*.meta_description.max' =>lang('api::slider.meta_description_max'),

            'translations.*.meta_keywords.string' =>lang('api::slider.meta_keywords_string'),
            'translations.*.meta_keywords.max' =>lang('api::slider.meta_keywords_max'),

            'translations.*.meta_tags.max' =>lang('api::slider.meta_tags_max'),

        ];
    }


}
