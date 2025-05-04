<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:30',
            'description' => 'nullable|string',
            'email' => 'required|email',
            'phone_number' => 'nullable|string|max:15',
            'mobile_number' => 'required|string|max:15',
            'address' => 'nullable|string',
            'footer' => 'nullable|string',
            'whatsapp' => 'required|string|max:15',
            'fax_number' => 'required|string',
            'logo' => 'nullable|file',
            'favicon' => 'nullable|file',
            'iphone_url' => 'nullable|string|regex:/^(https?:\/\/)?(www\.)?apps\.apple\.com\/app\/[a-zA-Z0-9-]+\/id[0-9]+/',
            'android_url' => 'nullable|string|regex:/^(https?:\/\/)?(www\.)?play\.google\.com\/store\/apps\/details\?id=[a-zA-Z0-9._]+/',
            'facebook_url' => 'nullable|url|regex:/^(https?:\/\/)?(www\.)?facebook\.com\/[a-zA-Z0-9(.?)?]/',
            'twitter_url' => 'nullable|url|regex:/^(https?:\/\/)?(www\.)?x\.com\/[a-zA-Z0-9_]{1,15}$/',
            'instagram_url' => 'nullable|url|regex:/^(https?:\/\/)?(www\.)?instagram\.com\/[a-zA-Z0-9_.]+$/',
            'snapchat_url' => 'nullable|url|regex:/^(https?:\/\/)?(www\.)?snapchat\.com\/add\/[a-zA-Z0-9_.]+$/',
            'tiktok_url' => 'nullable|url|regex:/^(https?:\/\/)?(www\.)?tiktok\.com\/add\/[a-zA-Z0-9_.]+$/',
        ];
    }
    public function messages()
    {
        return [

            'phone_number.required' => lang('api::setting.phone_number_required'),

            'address.required' => lang('api::setting.address_required'),

            'name.required' => lang('api::setting.name_required'),
            'name.string' => lang('api::setting.name_string'),
            'name.min' => lang('api::setting.name_min'),
            'name.max' => lang('api::setting.name_max'),

            'description.string' => lang('api::setting.description_string'),

            'email.required' => lang('api::setting.email_required'),
            'email.email' => lang('api::setting.email_invalid'),

            'phone_number.string' => lang('api::setting.phone_number_string'),
            'phone_number.max' => lang('api::setting.phone_number_max'),

            'mobile_number.required' => lang('api::setting.mobile_number_required'),
            'mobile_number.string' => lang('api::setting.mobile_number_string'),
            'mobile_number.max' => lang('api::setting.mobile_number_max'),

            'address.string' => lang('api::setting.address_string'),

            'footer.string' => lang('api::setting.footer_string'),

            'whatsapp.required' => lang('api::setting.whatsapp_required'),
            'whatsapp.string' => lang('api::setting.whatsapp_string'),
            'whatsapp.max' => lang('api::setting.whatsapp_max'),

            'fax_number.required' => lang('api::setting.fax_number_required'),
            'fax_number.string' => lang('api::setting.fax_number_string'),

            'logo.file' => lang('api::setting.logo_file'),
            'favicon.file' => lang('api::setting.favicon_file'),

            'iphone_url.string' => lang('api::setting.iphone_url_string'),
            'iphone_url.regex' => lang('api::setting.iphone_url_invalid'),

            'android_url.string' => lang('api::setting.android_url_string'),
            'android_url.regex' => lang('api::setting.android_url_invalid'),

            'facebook_url.url' => lang('api::setting.facebook_url_invalid'),
            'facebook_url.regex' => lang('api::setting.facebook_url_invalid'),

            'twitter_url.url' => lang('api::setting.twitter_url_invalid'),
            'twitter_url.regex' => lang('api::setting.twitter_url_invalid'),

            'instagram_url.url' => lang('api::setting.instagram_url_invalid'),
            'instagram_url.regex' => lang('api::setting.instagram_url_invalid'),

            'snapchat_url.url' => lang('api::setting.snapchat_url_invalid'),
            'snapchat_url.regex' => lang('api::setting.snapchat_url_invalid'),

            'tiktok_url.url' => lang('api::setting.tiktok_url_invalid'),
            'tiktok_url.regex' => lang('api::setting.tiktok_url_invalid'),

        ];
    }

}
