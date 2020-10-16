<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $string = file_get_contents("json/users.json");
        $data = json_decode($string, true);

        $users = [];
        foreach($data as $user) {
            $name = $user["last_name"] ? $user["first_name"] . ' ' . $user["last_name"] : $user["first_name"];
            array_push($users, [
                "id" => $user["id"],
                "name" => $name,
                'avatar' => $user['avatar'],
                'points' => $user['points'],
                'email' => $user['email'],
                'username' => $user['username'],
                'password' => $user['password'],
                'about' => $user['about'],
                'website_url' => $user['website_url'],
                'twitter_url' => $user['twitter_url'],
                'facebook_url' => $user['facebook_url'],
                'instagram_url' => $user['instagram_url'],
                'youtube_url' => $user['youtube_url'],
                'email_verified_at' => $user['email_verified_at'],
                'created_at' => $user['created_at'],
                'updated_at' => $user['updated_at'],
            ]);
        }

        DB::table('users')->insert($users);
    }
}
