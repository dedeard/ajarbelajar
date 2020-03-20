<?php

use App\Model\User;
use App\Model\Admin;
use App\Model\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123')
        ]);

        $admin = new Admin;
        $user->admin()->save($admin);

        $categories = [
            'Ilmu Komputer',
            'Ilmu Kedokteran',
            'Sosial Politik',
            'Keuangan',
            'Kehutanan'
        ];

        foreach($categories as $category){
            Category::create(['name' => $category]);
        }
    }
}
