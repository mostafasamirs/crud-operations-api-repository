<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{

    protected $fillable = [
        'name',
        'guard_name',
        'is_active',
    ];

    public static function getPermissions()
    {
        return [
            'roles.index' => ['index', 'show'],
            'roles.create' => ['create', 'store'],
            'roles.edit' => ['edit', 'update'],
            'roles.destroy' => ['destroy'],

        ];
    }

}
