<?php

namespace App\Http\Requests\Blog;

use App\Enums\StatusType;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'link' => 'nullable|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'nullable',
            'slug' => 'required|max:100|unique:blogs,slug,',
            'translations' => 'required|array',
            'translations.*.locale' => 'required',
            'translations.*.title' => 'required|string|min:2|max:50',
            'translations.*.short_description' => 'nullable|string|min:2|max:50',
            'translations.*.description' => 'required|string|min:2',
            'translations.*.meta_title' => 'nullable|string|max:255',
            'translations.*.meta_description' => 'nullable|string|max:255',
            'translations.*.meta_keywords' => 'nullable|string|max:255',
            'translations.*.meta_tags' => 'nullable|string|max:255',
        ];
    }
    public function messages()
    {
        return [

            'image.required' => lang('api::blog.image_required'),
            'image.image' => lang('api::blog.image_invalid'),
            'image.mimes' => lang('api::blog.image_invalid_mimes'),
            'image.max' => lang('api::blog.image_max_size'),

            'translations.required' => lang('api::blog.translations_required'),
            'translations.array' => lang('api::blog.translations_array'),

            'translations.*.locale.required' => lang('api::blog.locale_required'),

            'translations.*.title.required' => lang('api::blog.title_required'),
            'translations.*.title.string' => lang('api::blog.title_invalid'),
            'translations.*.title.min' => lang('api::blog.title_min'),
            'translations.*.title.max' => lang('api::blog.title_max'),

            'translations.*.slug.required' => lang('api::blog.slug_required'),
            'translations.*.slug.string' => lang('api::blog.slug_invalid'),
            'translations.*.slug.min' => lang('api::blog.slug_min'),
            'translations.*.slug.max' => lang('api::blog.slug_max'),

            'translations.*.short_description.string' => lang('api::blog.short_description_invalid'),
            'translations.*.short_description.min' => lang('api::blog.short_description_min'),
            'translations.*.short_description.max' => lang('api::blog.short_description_max'),

            'translations.*.description.required' => lang('api::blog.description_required'),
            'translations.*.description.string' => lang('api::blog.description_invalid'),
            'translations.*.description.min' => lang('api::blog.description_min'),

            'translations.*.meta_title.string' => lang('api::blog.meta_title_must_be_a_string'),
            'translations.*.meta_title.max' => lang('api::blog.meta_title_max_characters'),

            'translations.*.meta_description.string' => lang('api::blog.meta_description_must_be_a_string'),
            'translations.*.meta_description.max' => lang('api::blog.meta_description_max_characters'),

            'translations.*.meta_keywords.string' => lang('api::blog.meta_keywords_must_be_a_string'),
            'translations.*.meta_keywords.max' => lang('api::blog.meta_keywords_max_characters'),

            'translations.*.meta_tags.string' => lang('api::blog.meta_tags_must_be_a_string'),
            'translations.*.meta_tags.max' => lang('api::blog.meta_tags_max_characters'),

        ];
    }


}
