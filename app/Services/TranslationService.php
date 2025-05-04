<?php

namespace App\Services;

use App\Models\Translation;
use Illuminate\Support\Facades\Cache;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class TranslationService
{
    public static function retrieve()
    {
        if (!config('app.cache')) {
            return self::getTranslations();
        }

        return Cache::rememberForever('translations.all', function () {
            return self::getTranslations();
        });
    }

    protected static function getTranslations()
    {
        return array_replace_recursive(
            self::getFileTranslations(),
            self::getDatabaseTranslations()
        );
    }

    public static function getFileTranslations()
    {
        $translations = [];

        $basePath = base_path('lang');

        $packagePaths = [
            // Example: 'vendor/package' => base_path('vendor/package/lang'),
        ];

        $paths = array_merge([$basePath], $packagePaths);


        foreach (supported_locales() as $locale => $language) {
            foreach ($paths as $hint => $path) {
                $localePath = "{$path}/{$locale}";

                if (!is_dir($localePath)) {
                    continue;
                }

                $iterator = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($localePath, RecursiveDirectoryIterator::SKIP_DOTS)
                );

                foreach ($iterator as $file) {
                    if ($file->isFile() && $file->getExtension() === 'php') {
                        $fullPath = $file->getPathname();

                        $relativePath = substr($fullPath, strpos($fullPath, $localePath) + strlen($localePath) + 1);

                        $group = str_replace('.php', '', $relativePath);
                        $group = str_replace(DIRECTORY_SEPARATOR, '::', $group);

                        foreach (array_dot(require $file->getPathname()) as $key => $value) {
                            $translations["{$group}.{$key}"][$locale] = $value;
                        }
                    }
                }
            }
        }

        return $translations;
    }

    public static function getDatabaseTranslations()
    {
        $translations = [];

        foreach (Translation::all() as $translation) {

            foreach ($translation->translations as $translationTranslation) {
                $translations[$translation->key][$translationTranslation->locale] = $translationTranslation->value;
            }
        }

        return $translations;
    }

    public static function getTranslation($key, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();

        $translations = self::getTranslations();

        if (isset($translations[$key][$locale])) {
            return $translations[$key][$locale];
        }
        return null;
    }

    public static function flushCache()
    {
        Cache::forget('translations.all');
    }
}
