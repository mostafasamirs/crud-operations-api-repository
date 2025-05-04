<?php

namespace App\Http\Requests\NewsArticle;

use App\Enums\StatusType;
use Illuminate\Foundation\Http\FormRequest;

class StoreNewsArticleRequest extends FormRequest
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
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
            'slug' => 'required|max:100|unique:news_articles,slug,',
            'is_active' => 'nullable',
            'translations' => 'required|array',
            'translations.*.locale' => 'required',
            'translations.*.title' => 'required|string|max:50',
            'translations.*.description' => 'required|string',
            'translations.*.short_description' => 'nullable|string|max:100',
            'translations.*.meta_title' => 'nullable|string|max:255',
            'translations.*.meta_description' => 'nullable|string|max:255',
            'translations.*.meta_keywords' => 'nullable|string|max:255',
            'translations.*.meta_tags' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'url.required' => lang('api::news.url_required'),

            'url.url' => lang('api::news.url_invalid'),
            'is_active.required' => lang('api::news.is_active_required'),
            'translations.*.slug.unique' => lang('api::news.slug_unique'),
            'translations.*.description.max' => lang('api::news.description_max'),
            'translations.*.short_description.required' => lang('api::news.short_description_required'),

            'image.required' => lang('api::news.image_required'),
            'image.mimes' => lang('api::news.image_mimes'),
            'image.max' => lang('api::news.image_max'),

            'translations.required' => lang('api::news.translations_required'),
            'translations.array' => lang('api::news.translations_array'),

            'translations.*.locale.required' => lang('api::news.locale_required'),

            'translations.*.title.required' => lang('api::news.title_required'),
            'translations.*.title.string' => lang('api::news.title_string'),
            'translations.*.title.max' => lang('api::news.title_max'),

            'translations.*.slug.required' => lang('api::news.slug_required'),
            'translations.*.slug.string' => lang('api::news.slug_string'),
            'translations.*.slug.max' => lang('api::news.slug_max'),

            'translations.*.description.required' => lang('api::news.description_required'),
            'translations.*.description.string' => lang('api::news.description_string'),

            'translations.*.short_description.string' => lang('api::news.short_description_string'),
            'translations.*.short_description.max' => lang('api::news.short_description_max'),

            'translations.*.meta_title.string' => lang('api::news.meta_title_string'),
            'translations.*.meta_title.max' => lang('api::news.meta_title_max'),

            'translations.*.meta_description.string' => lang('api::news.meta_description_string'),
            'translations.*.meta_description.max' => lang('api::news.meta_description_max'),

            'translations.*.meta_keywords.string' => lang('api::news.meta_keywords_string'),
            'translations.*.meta_keywords.max' => lang('api::news.meta_keywords_max'),

            'translations.*.meta_tags.string' => lang('api::news.meta_tags_string'),
            'translations.*.meta_tags.max' => lang('api::news.meta_tags_max'),

        ];
    }
}
