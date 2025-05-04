<?php

namespace App\Enums;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\Vendor;

//use App\Models\Employee;

class GuardType extends BaseEnumeration
{
    public const GUARD_TYPE_ADMIN = 'admin';

    /**
     * @return string[]
     */
    public static function getModel(string $value = ''): array
    {
        return [
            self::GUARD_TYPE_ADMIN => Admin::class,
        ];
    }

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
        $enumerationTranslation = 'general.guard_type_';

        return [
            self::GUARD_TYPE_ADMIN => __($enumerationTranslation . self::GUARD_TYPE_ADMIN),
        ];
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function isAdmin(string $value): bool
    {
        return self::is($value, 'GUARD_TYPE_ADMIN');
    }


    /**
     * @return string
     */
    public static function getAdmin(): string
    {
        return self::GUARD_TYPE_ADMIN;
    }

}
