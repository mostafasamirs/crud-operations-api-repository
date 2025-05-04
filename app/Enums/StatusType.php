<?php

namespace App\Enums;

class StatusType extends BaseEnumeration
{
    public const STATUS_TYPE_ACTIVE = '1';

    public const STATUS_TYPE_NOT_ACTIVE = '0';


    public static function getListExcept(int $key): array
    {
        $data = self::getList();
        unset($data[$key]);

        return $data;
    }

    public static function getList(string $value = ''): array
    {
        $enumerationTranslation = 'general.status_type_';

        return [
            self::STATUS_TYPE_ACTIVE => __($enumerationTranslation . self::STATUS_TYPE_ACTIVE),
            self::STATUS_TYPE_NOT_ACTIVE => __($enumerationTranslation . self::STATUS_TYPE_NOT_ACTIVE),
        ];
    }

    public static function isActive(string $value): bool
    {
        return self::is($value, 'STATUS_TYPE_ACTIVE');
    }

    public static function isNotActive(string $value): bool
    {
        return self::is($value, 'STATUS_TYPE_NOT_ACTIVE');
    }


    public static function getActive(): string
    {
        return self::STATUS_TYPE_ACTIVE;
    }

    public static function getNotActive(): string
    {
        return self::STATUS_TYPE_NOT_ACTIVE;
    }

}
