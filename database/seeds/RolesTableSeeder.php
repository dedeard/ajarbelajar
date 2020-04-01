<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'manage user']);
        Permission::create(['name' => 'manage minitutor']);
        Permission::create(['name' => 'manage post']);
        Permission::create(['name' => 'manage comment']);
        Permission::create(['name' => 'manage category']);
        Permission::create(['name' => 'manage seo']);

        Role::create(['name' => 'Super Admin']);

        $roleAdmin = Role::create(['name' => 'Administrator']);
        $roleAdmin->givePermissionTo(['manage user', 'manage minitutor', 'manage post', 'manage category', 'manage seo']);

        $roleModerator = Role::create(['name' => 'Moderator']);
        $roleModerator->givePermissionTo(['manage post', 'manage category']);
    }
}
