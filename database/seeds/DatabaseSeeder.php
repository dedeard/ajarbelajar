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
        // $this->call([UserTableSeeder::class]);
        $this->call([RoleTableSeeder::class]);
        // $this->call([MinitutorTableSeeder::class]);
        // $this->call([CategoryTableSeeder::class]);
        // $this->call([PostTableSeeder::class]);
        // $this->call([CommentTableSeeder::class]);
        // $this->call([FeedbackTableSeeder::class]);
        // $this->call([ViewTableSeeder::class]);
        // $this->call([SubscribeTableSeeder::class]);
    }
}
