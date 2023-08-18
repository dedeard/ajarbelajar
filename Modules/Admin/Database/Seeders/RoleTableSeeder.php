<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Entities\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Role::where('name', 'super admin')->exists()) {
            Role::factory()->create([
                'name' => 'super admin',
                'display_name' => 'Super Admin',
                'description' => 'Peran Super Admin memiliki akses penuh ke semua fitur dan fungsionalitas aplikasi. Peran ini ditujukan untuk tujuan administratif dan sebaiknya diberikan kepada pengguna yang dipercayai dengan hak istimewa tingkat tinggi.',
                'is_protected' => true,
            ]);
        }
    }
}
