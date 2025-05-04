<?php


use App\Models\Setting;
use App\Services\TranslationService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

if (!function_exists('setting')) {

    function setting($key = null)
    {
        if (is_null($key)) {
            return app('setting');
        }

        if (is_array($key)) {

            return app('setting')->setMany($key);
        }

        try {
            return app('setting')->get($key);
        } catch (PDOException $e) {
            return null;
        }
    }
}
if (!function_exists('getSupportedLocales')) {
    function getSupportedLocales(): array
    {
        $setting = Setting::where('key', 'supported_locales')->first();

        if ($setting && $setting->plain_value) {
            return json_decode($setting->plain_value, true);
        }

        return ['ar'];
    }
}
if (!function_exists('deleteMedia')) {
    function deleteMedia($model, $collection_name)
    {
        if ($model?->media && $model->media?->isNotEmpty()) {
            $model->clearMediaCollection($collection_name);
        }
    }
}

if (!function_exists('getSettings')) {
    function getSettings($key)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting?->plain_value ?? null;
    }
}
if (!function_exists('updateImage')) {
    function updateImage($request, $model, $collection_name)
    {
        if ($request->hasFile($collection_name)) {
            $model->clearMediaCollection($collection_name);
            $model->addMediaFromRequest($collection_name)->toMediaCollection($collection_name);
        }
    }
}

if (!function_exists('addImage')) {
    function addImage($request, $model, $collection_name)
    {
        if ($request->hasFile($collection_name)) {
            $model->addMediaFromRequest($collection_name)->toMediaCollection($collection_name);
        }
    }
}


/**
 * @return mixed
 */
if (!function_exists('showFile')) {
    function showFile($model, $collectionName, $conversionName = 'webp')
    {
        if (!$model->hasMedia($collectionName)) {
            return null; // Or return a default placeholder URL
        }

        return $model->getFirstMediaUrl($collectionName, $conversionName);
    }
}


/**
 * @return string
 */
if (!function_exists('regexValidationArabic')) {
    function regexValidationArabic()
    {
        return 'regex:/^[\p{Arabic}\s0-9٠-٩\-_.,!?@#$%^&*()+={\[}\]|\\:;"\'<>\/]+$/u';
    }
}

/**
 * @return string
 */
if (!function_exists('regexValidationEnglish')) {
    function regexValidationEnglish()
    {
        return 'regex:/^[a-zA-Z0-9\s\-_.,!?@#$%^&*()+={\[}\]|\\:;"\'<>\/]+$/';
    }
}


/**
 * @return string
 */
if (!function_exists('regexValidation')) {
    function regexValidation()
    {
        return 'not_regex:/^["\'`||\/\/\\\\=+\-*%^&(){}[\]<>~!@#$:;,\.?\s0-9]/';
    }
}
if (!function_exists('supported_locales')) {
    function supported_locales()
    {
        return LaravelLocalization::getSupportedLocales();
    }
}
if (!function_exists('formatSupportedLocales')) {
    function formatSupportedLocales($locales)
    {
        $formattedLocales = [];

        foreach ($locales as $code => $details) {
            $formattedLocales[] = [
                'code' => $code,
                'name' => $details['native'],
            ];
        }

        return $formattedLocales;
    }
}
if (!function_exists('array_dot')) {
    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param array $array
     * @param string $prepend
     * @return array
     */
    function array_dot($array, $prepend = '')
    {
        return Arr::dot($array, $prepend);
    }
}
if (!function_exists('array_has')) {
    /**
     * Check if an item or items exist in an array using "dot" notation.
     *
     * @param ArrayAccess|array $array
     * @param string|array $keys
     * @return bool
     */
    function array_has($array, $keys)
    {
        return Arr::has($array, $keys);
    }
}
if (!function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param ArrayAccess|array $array
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        return Arr::get($array, $key, $default);
    }
}

if (!function_exists('lang')) {
    function lang($key, $locale = null)
    {
        return TranslationService::getTranslation($key, $locale);
    }
}
if (!function_exists('locales')) {
    function locales()
    {
        return app()->getLocale();
    }
}

/**
 * @return mixed
 */
if (!function_exists('showDate')) {
    function showDate($time)
    {
        return Carbon::parse($time)->format('d-m-Y h:i A');
    }
}

