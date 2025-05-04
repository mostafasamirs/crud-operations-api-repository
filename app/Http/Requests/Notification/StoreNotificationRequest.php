<?php

namespace App\Http\Requests\Notification;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
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
            'url' => 'required|url',
            'mobile_link' => 'required|url',
            'user_type' => 'required|in:1',
            'managers' => 'required|in:0,1',
            'members' => 'required|in:0,1',
            'both' => 'required|in:0,1',
            'sms' => 'required|in:0,1',
            'email' => 'required|in:0,1',
            'system_notification' => 'required|in:0,1',
            'app_users' => 'required|in:0,1',
            'website_users' => 'required|in:0,1',
            'admins' => 'required|in:0,1',
            'translations' => 'required|array',
            'translations.*.locale' => 'required|string',
            'translations.*.title' => 'required|string|max:30',
            'translations.*.body' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'mobile_link.max' => lang('api::notification.mobile_link_max'),
            'app_users.required' => lang('api::notification.app_users_required'),
            'app_users.in' => lang('api::notification.app_users_invalid'),

            'website_users.required' => lang('api::notification.website_users_required'),
            'website_users.in' => lang('api::notification.website_users_invalid'),

            'admins.required' => lang('api::notification.admins_required'),
            'admins.in' => lang('api::notification.admins_invalid'),

            'sms.boolean' => lang('api::notification.sms_invalid'),

            'email.boolean' => lang('api::notification.email_invalid'),

            'system_notification.boolean' => lang('api::notification.system_notification_invalid'),
            'translations.*.body.max' => lang('api::notification.body_max'),

            'url.required' => lang('api::notification.url_required'),
            'url.url' => lang('api::notification.url_invalid'),

            'mobile_link.required' => lang('api::notification.mobile_link_required'),
            'mobile_link.url' => lang('api::notification.mobile_link_invalid'),

            'user_type.required' => lang('api::notification.user_type_required'),
            'user_type.in' => lang('api::notification.user_type_invalid'),

            'managers.required' => lang('api::notification.managers_required'),
            'managers.in' => lang('api::notification.managers_invalid'),

            'members.required' => lang('api::notification.members_required'),
            'members.in' => lang('api::notification.members_invalid'),

            'both.required' => lang('api::notification.both_required'),
            'both.in' => lang('api::notification.both_invalid'),

            'sms.required' => lang('api::notification.sms_required'),
            'sms.in' => lang('api::notification.sms_invalid'),

            'email.required' => lang('api::notification.email_required'),
            'email.in' => lang('api::notification.email_invalid'),

            'system_notification.required' => lang('api::notification.system_notification_required'),
            'system_notification.in' => lang('api::notification.system_notification_invalid'),

            'app.required' => lang('api::notification.app_required'),
            'app.in' => lang('api::notification.app_invalid'),

            'website.required' => lang('api::notification.website_required'),
            'website.in' => lang('api::notification.website_invalid'),

            'dashboard.required' => lang('api::notification.dashboard_required'),
            'dashboard.in' => lang('api::notification.dashboard_invalid'),

            'translations.required' => lang('api::notification.translations_required'),
            'translations.array' => lang('api::notification.translations_array'),

            'translations.*.locale.required' => lang('api::notification.locale_required'),
            'translations.*.locale.string' => lang('api::notification.locale_string'),

            'translations.*.title.required' => lang('api::notification.title_required'),
            'translations.*.title.string' => lang('api::notification.title_string'),
            'translations.*.title.max' => lang('api::notification.title_max'),

            'translations.*.body.required' => lang('api::notification.body_required'),
            'translations.*.body.string' => lang('api::notification.body_string'),

        ];
    }

}
