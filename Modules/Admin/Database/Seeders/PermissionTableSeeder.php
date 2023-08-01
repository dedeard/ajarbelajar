<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Entities\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the array of permissions from the getPermissions method
        $permissions = $this->getPermissions();

        // Loop through each permission and create if it does not exist in the database
        foreach ($permissions as $permission) {
            if (! Permission::where('name', $permission['name'])->exists()) {
                Permission::factory()->create($permission);
            }
        }

        // Retrieve permissions from the database with slugs not present in the $permissions array
        $permissionsToDelete = Permission::whereNotIn('name', array_map(fn ($item) => $item['name'], $permissions))->get();

        // Delete the selected permissions
        $permissionsToDelete->each(fn ($item) => $item->delete());
    }

    /**
     * Get the predefined permissions array.
     */
    private function getPermissions(): array
    {
        return [
            [
                'name' => 'read user',
                'display_name' => 'Tampilkan Pengguna',
                'description' => 'Memungkinkan untuk melihat detail pengguna.',
            ],
            [
                'name' => 'edit user',
                'display_name' => 'Edit Pengguna',
                'description' => 'Memberikan izin untuk mengubah informasi pengguna.',
            ],
            [
                'name' => 'create user',
                'display_name' => 'Buat Pengguna',
                'description' => 'Memungkinkan pembuatan akun pengguna baru.',
            ],
            [
                'name' => 'delete user',
                'display_name' => 'Hapus Pengguna',
                'description' => 'Mengizinkan penghapusan akun pengguna.',
            ],

            [
                'name' => 'read admin',
                'display_name' => 'Tampilkan Admin',
                'description' => 'Memungkinkan untuk melihat informasi admin.',
            ],
            [
                'name' => 'edit admin',
                'display_name' => 'Edit Admin',
                'description' => 'Memberikan izin untuk mengubah detail admin.',
            ],
            [
                'name' => 'create admin',
                'display_name' => 'Buat Admin',
                'description' => 'Memungkinkan pembuatan akun admin baru.',
            ],
            [
                'name' => 'delete admin',
                'display_name' => 'Hapus Admin',
                'description' => 'Mengizinkan penghapusan akun admin.',
            ],

            [
                'name' => 'read role',
                'display_name' => 'Akses Peran',
                'description' => 'Memungkinkan untuk melihat detail dan penugasan peran.',
            ],
            [
                'name' => 'edit role',
                'display_name' => 'Edit Peran',
                'description' => 'Memberikan izin untuk mengubah konfigurasi peran.',
            ],
            [
                'name' => 'create role',
                'display_name' => 'Buat Peran',
                'description' => 'Memungkinkan pembuatan peran baru.',
            ],
            [
                'name' => 'delete role',
                'display_name' => 'Hapus Peran',
                'description' => 'Mengizinkan penghapusan peran dari sistem.',
            ],
        ];
    }
}
