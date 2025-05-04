<?php

namespace App\Enums;

class DefaultType extends BaseEnumeration
{
    public const STATUS_TYPE_ACTIVE = '1';

    public const STATUS_TYPE_NOT_ACTIVE = '0';


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
        $enumerationTranslation = 'general.default_type_';

        return [
            self::STATUS_TYPE_ACTIVE => __($enumerationTranslation . self::STATUS_TYPE_ACTIVE),
            self::STATUS_TYPE_NOT_ACTIVE => __($enumerationTranslation . self::STATUS_TYPE_NOT_ACTIVE),
        ];
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function isActive(string $value): bool
    {
        return self::is($value, 'STATUS_TYPE_ACTIVE');
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function isNotActive(string $value): bool
    {
        return self::is($value, 'STATUS_TYPE_NOT_ACTIVE');
    }


    /**
     * @return string
     */
    public static function getActive(): string
    {
        return self::STATUS_TYPE_ACTIVE;
    }

    /**
     * @return string
     */
    public static function getNotActive(): string
    {
        return self::STATUS_TYPE_NOT_ACTIVE;
    }

}
