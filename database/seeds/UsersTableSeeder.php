<?php

use App\Model\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'username' => 'superadmin',
            'email' => 'super@admin.com',
            'password' => Hash::make('admin123')
        ]);
        $admin = User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123')
        ]);
        $moderator = User::create([
            'first_name' => 'moderator',
            'last_name' => 'admin',
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
