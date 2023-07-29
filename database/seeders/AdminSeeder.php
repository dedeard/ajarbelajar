<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([PermissionSeeder::class, RoleSeeder::class]);

        $data = [
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => 'Super Admin',
            'password' => Hash::make('superadmin'),
            'is_active' => true,
            'role_id' => Role::where('name', 'Super Admin')->first()->id,
        ];

        if (! Admin::where('email', $data['email'])->exists()) {
            Admin::factory()->create($data);
        }
    }
}
