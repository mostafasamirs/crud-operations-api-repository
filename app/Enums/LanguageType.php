<?php

namespace App\Enums;

class LanguageType extends BaseEnumeration
{
    public const LANGUAGES_TYPE_ARABIC = 'ar';

    public const LANGUAGES_TYPE_ENGLISH = 'en';

    /**
     * @param int $key
     * @return array
     */
    public static function getListExcept(int $key): array
    {
        $data = self::getList();
        unset($data[$key]);

        return $data;
    }

    /**
     * @param string $value
     * @return array
     */
    public static function getList(string $value = ''): array
    {
        $enumerationTranslation = 'general.language_type_';

        return [
            self::LANGUAGES_TYPE_ARABIC => __($enumerationTranslation . self::LANGUAGES_TYPE_ARABIC),
            self::LANGUAGES_TYPE_ENGLISH => __($enumerationTranslation . self::LANGUAGES_TYPE_ENGLISH),
        ];
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function isArabic(string $value): bool
    {
        return self::is($value, 'LANGUAGES_TYPE_ARABIC');
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function isEnglish(string $value): bool
    {
        return self::is($value, 'LANGUAGES_TYPE_ENGLISH');
    }

    /**
     * @return string
     */
    public static function getArabic(): string
    {
        return self::LANGUAGES_TYPE_ARABIC;
    }

    /**
     * @return string
     */
    public static function getEnglish(): string
    {
        return self::LANGUAGES_TYPE_ENGLISH;
    }

    /**
     * @return string[]
     */
    public static function getAllLanguages()
    {
        return [
            self::LANGUAGES_TYPE_ARABIC,
            self::LANGUAGES_TYPE_ENGLISH,
        ];
    }
}
