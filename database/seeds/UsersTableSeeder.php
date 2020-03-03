<?php

use App\Model\User;
use App\Model\Admin;
use App\Model\RequestMinitutor;
use App\Model\UserProfile;
use App\Model\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin')
        ]);

        $admin = new Admin;
        $profile = new UserProfile([
            'first_name' => 'dede',
            'last_name' => 'ardiansya',
        ]);

        $user->admin()->save($admin);
        $user->profile()->save($profile);


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
