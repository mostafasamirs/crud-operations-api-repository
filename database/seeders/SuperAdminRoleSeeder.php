<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class SuperAdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create or find the Super Admin role
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'admin']);

        // Assign all permissions to Super Admin
        $allPermissions = Permission::where('guard_name', 'admin')->pluck('name')->toArray();
        $superAdminRole->syncPermissions($allPermissions);

        // Assign the Super Admin role to a specific user (change the email as needed)
        $superAdminUser = Admin::create([
            'is_active' => 1,
            'mobile' => "123456789",
            'nationality_id' => 1,
            'country_id' => 2,
            'email' => "admin@admin.com",
            'password' => Hash::make('123456789'),
            'identity' => "123456"
        ]);
        if ($superAdminUser) {
            $superAdminUser->assignRole($superAdminRole);
        }
    }
}
