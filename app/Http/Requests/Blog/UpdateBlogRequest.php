<?php

namespace App\Http\Requests\Blog;

use App\Enums\StatusType;
use App\Models\Blog;
use App\Traits\UniqueSlugRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
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
            'link' => 'nullable|url',
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'nullable',
            'slug' => [
                'required',
                'max:100',
                Rule::unique('blogs', 'slug')->whereNull('deleted_at')->ignore($this->uuid, 'uuid'),
            ],
            'translations' => 'required|array',
            'translations.*.locale' => 'required',
            'translations.*.title' => 'required|string|min:2|max:255',
            'translations.*.short_description' => 'nullable|string|min:2|max:300',
            'translations.*.description' => 'required|string|min:2|max:500',
            'translations.*.meta_title' => 'nullable|string|max:255',
            'translations.*.meta_description' => 'nullable|string|max:255',
            'translations.*.meta_keywords' => 'nullable|string|max:255',
            'translations.*.meta_tags' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return[
            'translations.*.meta_title.string' => lang('api::blog.meta_title_must_be_a_string'),
            'translations.*.meta_title.max' => lang('api::blog.meta_title_max_characters'),

            'translations.*.meta_description.string' => lang('api::blog.meta_description_must_be_a_string'),
            'translations.*.meta_description.max' => lang('api::blog.meta_description_max_characters'),

            'translations.*.meta_keywords.string' => lang('api::blog.meta_keywords_must_be_a_string'),
            'translations.*.meta_keywords.max' => lang('api::blog.meta_keywords_max_characters'),
            'translations.*.slug.required' => lang('api::blog.slug_required'),
            'translations.*.slug.unique' => lang('api::blog.slug_unique'),
            'translations.*.meta_tags.string' => lang('api::blog.meta_tags_must_be_a_string'),
            'translations.*.meta_tags.max' => lang('api::blog.meta_tags_max_characters'),
            'translations.required' => lang('api::blog.translations_required'),
            'translations.array' => lang('api::blog.translations_array'),
            'translations.*.locale.required' => lang('api::blog.locale_required'),
            'translations.*.title.required' => lang('api::blog.title_required'),
            'translations.*.title.string' => lang('api::blog.title_invalid'),
            'translations.*.title.max' => lang('api::blog.title_max'),
            'translations.*.description.required' => lang('api::blog.description_required'),
            'translations.*.description.string' => lang('api::blog.description_invalid'),
            'translations.*.description.max' => lang('api::blog.description_max'),
            'translations.*.short_description.required' => lang('api::blog.short_description_required'),
            'translations.*.short_description.string' => lang('api::blog.short_description_invalid'),
            'translations.*.short_description.max' => lang('api::blog.short_description_max'),
            'link.required' => lang('api::blog.url_required'),
            'link.url' => lang('api::blog.url_invalid'),
            'image.required' => lang('api::blog.image_required'),
            'image.mimes' => lang('api::blog.image_invalid_mimes'),
            'image.max' => lang('api::blog.image_max_size'),
            'is_active.required' => lang('api::blog.is_active_required'),

            'image.image' => lang('api::blog.image_invalid'),
            'translations.*.title.min' => lang('api::blog.title_min'),
            'translations.*.slug.string' => lang('api::blog.slug_invalid'),
            'translations.*.slug.min' => lang('api::blog.slug_min'),
            'translations.*.slug.max' => lang('api::blog.slug_max'),
            'translations.*.short_description.min' => lang('api::blog.short_description_min'),
            'translations.*.description.min' => lang('api::blog.description_min'),


        ];
    }

}

