<?php

namespace Database\Seeders;

use App\Enums\GuardType;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'user',
            'moderator'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'admin',
            ], [
                'is_active' => 1
            ]);
        }

        $adminRole = Role::where('name', 'admin')->where('guard_name', 'admin')->first();
        if ($adminRole) {
            $adminPermissions = Permission::where('guard_name', GuardType::getAdmin())->get();
            $adminRole->syncPermissions($adminPermissions);
            $admins = Admin::all();
            foreach ($admins as $admin) {
                setPermissionsTeamId(0);
                if (!$admin->hasRole($adminRole->name)) {
                    $admin->assignRole($adminRole);
                }
            }
        }
    }
}
