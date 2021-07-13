<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "Super Admin",
            "username" => "superadmin",
            "email" => "super@admin.com",
            "password" => Hash::make("superadmin"),
        ]);
        $this->call([RoleTableSeeder::class]);
    }
}
