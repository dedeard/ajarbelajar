<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'admin access']);
        Permission::create(['name' => 'manage role']);
        Permission::create(['name' => 'manage permission']);

        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Administrator']);
        Role::create(['name' => 'Moderator']);

        $superadmin = User::where('username', 'superadmin')->first();
        $superAdminRole = Role::findByName('Super Admin');
        $superadmin->syncRoles($superAdminRole);
    }
}
