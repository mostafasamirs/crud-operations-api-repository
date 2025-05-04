<?php

namespace App\Http\Resources\Dashboard\AdminData\Translation;

use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TranslationResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request)
    {
        // Ensure resource is an object
        $translation = is_array($this->resource) ? (object)$this->resource : $this->resource;

        // Check if translation_id exists before accessing it
        $translationModel = isset($translation->translation_id)
            ? Translation::find($translation->translation_id)
            : null;

        // Use the retrieved model's key and ID
        $key = $translationModel->key ?? $translation->key ?? null;
        $translationId = $translationModel->id ?? $translation->id ?? null;

        // Retrieve translations and ensure it's an array
        $translations = isset($translation->translations)
            ? collect($translation->translations)->keyBy('locale')->toArray()
            : [];

        if ($this->isUpdateRequest($request)) {
            $data = [
                'id' => $translationId,  // Ensure ID is correctly set
                'key' => $key,  // Correctly retrieve the key
                'locale' => $translation->locale ?? null,
                'value' => $translation->value ?? null,
            ];
        } else {
            $data = [
                'translations' => [
                    'ar' => $translation->ar ?? null,
                    'en' => $translation->en ?? null,
                ],
            ];
        }

        return $data;
    }

    /**
     * Check if the request is an update request.
     */
    protected function isUpdateRequest($request)
    {
        return ($request->update === true)
            || ($request->route('key') && in_array($request->method(), ['PUT', 'PATCH', 'POST']) && !str_contains($request->path(), 'change-status'))
            || ($request->isMethod('post') && !str_contains($request->path(), 'change-status'));
    }


}
