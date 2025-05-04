<?php

namespace App\Http\Resources\Dashboard\AdminData\FAQS;

use App\Enums\StatusType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FAQSResource extends JsonResource
{

    public function toArray(Request $request)
    {
        $this->resource->load('translations');

        $fields = ['question', 'answer'];
        $data = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'is_active' => StatusType::getValue($this->is_active),
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
        // Check if the route contains a 'uuid' parameter, which is typical for update requests,
        // and ensure the request path does not contain 'change-status'.
        return ($request->update == true)
            || (($request->route('uuid') && in_array($request->method(), ['PUT', 'PATCH', 'POST'])) && !str_contains($request->path(), 'change-status'))
            || ($request->isMethod('post') && !str_contains($request->path(), 'change-status'));
    }

}
