<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::create([
            'name' => 'super',
            'username' => 'superadmin',
            'email' => 'super@admin.com',
            'password' => Hash::make('admin123')
        ]);
        $admin = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123')
        ]);
        $moderator = User::create([
            'name' => 'moderator',
            'username' => 'moderator',
            'email' => 'moderator@admin.com',
            'password' => Hash::make('admin123')
        ]);

        $superAdminRole = Role::findByName('Super Admin');
        $adminRole = Role::findByName('Administrator');
        $moderatorRole = Role::findByName('Moderator');

        $superadmin->syncRoles($superAdminRole);
        $admin->syncRoles($adminRole);
        $moderator->syncRoles($moderatorRole);
    }
}
