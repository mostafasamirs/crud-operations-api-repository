<?php

namespace App\Http\Resources\Dashboard\AdminData\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResources extends JsonResource
{
    public function toArray(Request $request)
    {
        $this->resource->load('translations');
        $fields = ['title', 'body'];
        $data = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'url' => $this->url,
            'mobile_link' => $this->mobile_link,
            'website_users' => $this->website_users,
            'app_users' => $this->app_users,
            'admins' => $this->admins,
            'managers' => $this->managers,
            'members' => $this->members,
            'both' => $this->both,
            'system_notification' => $this->system_notification,
            'sms' => $this->sms,
            'email' => $this->email,
        ];

        $translations = $this->translations->keyBy('locale')->sortByDesc(fn($_, $key) => $key == 'en');
        if (!$this->isUpdateRequest($request)) {
            $translations = array_values($this->translations->keyBy('locale')->sortByDesc(fn($_, $key) => $key == 'en')->toArray());
            foreach ($translations as $index => $translationItem) {
                if ($translationItem['locale'] == $request->header('lang')) {
                    foreach ($fields as $field) {
                        $data["translations[$index][$field]"] = $translationItem[$field] ?? null;
                    }
                }
            }
        } else {
            foreach ($translations->values() as $index => $translation) {
                foreach ($fields as $field) {
                    $data["translations[$index][$field]"] = $translation[$field] ?? null;
                }
            }
        }

        return $data;
    }

    /**
     * @param $request
     * @return bool
     */
    protected function isUpdateRequest($request)
    {
        // Check if the route contains a 'uuid' parameter, which is typical for update requests,
        // and ensure the request path does not contain 'change-status'.
        return ($request->update == true)
            || (($request->route('uuid') && in_array($request->method(), ['PUT', 'PATCH', 'POST'])) && !str_contains($request->path(), 'change-status'))
            || ($request->isMethod('post') && !str_contains($request->path(), 'change-status'));
    }

}
