<?php

use App\Models\Minitutor;
use App\Models\RequestArticle;
use App\Models\RequestMinitutor;
use App\Models\RequestPost;
use App\Models\RequestVideo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([RolesTableSeeder::class]);
        $this->call([UsersTableSeeder::class]);
        $this->call([CategoriesTableSeeder::class]);

        $faker = Faker::create('id_ID');

        // users
        for ($i = 1; $i <= 50; $i++) {
            DB::table('users')->insert([
                'first_name' => $faker->firstNameMale,
                'last_name' => $faker->lastName,
                'username' => $faker->username,
                'email' => $faker->email,
                'password' => Hash::make('user'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach(User::all() as $user){
            // Minitutor
            $data = [
                'last_education' => ['D1', 'D2', 'D3', 'S1', 'S2', 'S3'][$faker->numberBetween(0, 5)],
                'university' => $faker->companySuffix,
                'city_and_country_of_study' => $faker->country,
                'majors' => ['Teknik', 'Kedokteran', 'Pertanian', 'Hukum', 'Perikanan', 'Sastra'][$faker->numberBetween(0, 5)],
                'interest_talent' => $faker->text(150),
                'contact' => $faker->e164PhoneNumber,
                'reason' => $faker->text(150),
                'expectation' => $faker->text(150)
            ];
            $requestMinitutor = new RequestMinitutor($data);
            $user->requestMinitutor()->save($requestMinitutor);
        }

        foreach([1,2,3,4,5,6,7,8,9] as $id) {
            $requestData = RequestMinitutor::findOrFail($id);
            $requestDataCopy = $requestData;
            $requestDataCopy = $requestDataCopy->toArray();

            unset($requestDataCopy['created_at']);
            unset($requestDataCopy['updated_at']);
            unset($requestDataCopy['id']);

            $requestDataCopy['active'] = true;
            $minitutor = Minitutor::create($requestDataCopy);
            $requestData->delete();

            foreach([1,2,3,4,5,6,7,8,9,10] as $x){
                $video = new RequestPost([
                    'title' => $faker->sentence(8, true),
                    'description' => $faker->text(200),
                    'category_id' => $faker->numberBetween(1, 5),
                    'videos' => $faker->url,
                    'type' => 'video',
                    'requested_at' => now()
                ]);
                $article = new RequestPost([
                    'title' => $faker->sentence(8, true),
                    'description' => $faker->text(200),
                    'category_id' => $faker->numberBetween(1, 5),
                    'videos' => $faker->url,
                    'type' => 'article',
                    'requested_at' => now()
                ]);
                $minitutor->user->requestPosts()->save($video);
                $minitutor->user->requestPosts()->save($article);
            }
        }
    }
}
