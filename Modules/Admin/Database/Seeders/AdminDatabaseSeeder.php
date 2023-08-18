<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Entities\Role;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([PermissionTableSeeder::class, RoleTableSeeder::class]);

        $data = [
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => 'Super Admin',
            'password' => Hash::make('superadmin'),
            'is_active' => true,
            'role_id' => Role::where('name', 'super admin')->first()->id,
        ];

        if (!Admin::where('email', $data['email'])->exists()) {
            Admin::factory()->create($data);
        }
    }
}
