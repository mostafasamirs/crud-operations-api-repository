<?php

namespace App\Http\Resources\Dashboard\AdminData\settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResource extends JsonResource
{

    public function toArray(Request $request)
    {
        $this->resource->load('translations');
        $fields = ['value'];
        $data = [
            'id' => $this->id,
            'key' => $this->key,
            'field_type' => $this->field_type,
            'plain_value' => $this->plain_value,
            'is_translatable' => $this->is_translatable,
            'created_at' => showDate($this->created_at),
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

    protected function isUpdateRequest($request)
    {
        // Check if the route contains an 'id' parameter and which is typical for update requests and not request path change-status
        return ($request->update == true) || ($request->route('id') && in_array($request->method(), ['PUT', 'PATCH', 'POST']) && !str_contains($request->path(), 'change-status'));
    }

}
