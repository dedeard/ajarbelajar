<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'admin access']);
        Permission::create(['name' => 'manage role']);
        Permission::create(['name' => 'manage permission']);
        Permission::create(['name' => 'manage user']);
        Permission::create(['name' => 'manage minitutor']);
        Permission::create(['name' => 'manage post']);
        Permission::create(['name' => 'manage comment']);
        Permission::create(['name' => 'manage category']);
        Permission::create(['name' => 'manage seo']);

        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Administrator']);
        Role::create(['name' => 'Moderator']);

        $superadmin = User::where('username', 'superadmin')->first();
        $superAdminRole = Role::findByName('Super Admin');
        $superadmin->syncRoles($superAdminRole);
    }
}
