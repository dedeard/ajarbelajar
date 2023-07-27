<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Role::where('name', 'Super Admin')->exists()) {
            Role::factory()->create([
                'name' => 'super admin',
                'display_name' => 'Super Admin',
                'description' => "Peran Super Admin memiliki akses penuh ke semua fitur dan fungsionalitas aplikasi. Peran ini ditujukan untuk tujuan administratif dan sebaiknya diberikan kepada pengguna yang dipercayai dengan hak istimewa tingkat tinggi.",
                'is_protected' => true,
            ]);
        }
    }
}
