<?php

use App\Models\Article;
use App\Models\Feedback;
use App\Models\Minitutor;
use App\Models\User;
use App\Models\View;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Kreait\Firebase\Database;

class DevSeeder extends Seeder
{
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    private function requestMinitutorSeed($user) {
        $faker = Factory::create();
        $uid = (string) $user->id;
        $ref = $this->database->getReference('request_minitutor/_' . $uid);

        $data = [
            'last_education' => ['D1', 'D2', 'D3', 'S1', 'S2', 'S3'][$faker->numberBetween(0, 5)],
            'university' => $faker->company,
            'city_and_country_of_study' => $faker->city . ', ' . $faker->country,
            'majors' => $faker->jobTitle,
            'contact' => $faker->phoneNumber,
            'interest_talent' => $faker->realText(80),
            'reason' => $faker->realText(250),
            'expectation' => $faker->realText(250),
            'cv' => '',
            'created_at' =>  ['.sv' => 'timestamp']
        ];

        try {
            $ref->set($data);
        } catch (Exception $e) {
        }
    }

    public function run()
    {

        $faker = Factory::create();

        $users = User::all();
        foreach ($users as $user) {
            $user->points = $faker->numberBetween(0,1000);
            $user->save();
        }

        return true;

        // $this->call([RoleTableSeeder::class]);
        // $this->call([UserTableSeeder::class]);

        factory(User::class, 200)->create()->each(function($user) use($faker) {
            if($faker->boolean()) {
                $user->minitutor()->save(factory(Minitutor::class)->make());
            } else {
                if($faker->boolean()) {
                $this->requestMinitutorSeed($user);
            }
            }

            $article = Article::findOrFail(1);
            if($faker->boolean()) {
                $view = new View([
                    'user_id' => $user->id,
                    'ip' => $faker->ipv4,
                    'agent' => $faker->userAgent
                ]);
                $article->views()->save($view);
            }
            if($faker->boolean()) {
                $feedback = new Feedback([
                    'user_id' => $user->id,
                    'sync_with_me' => $faker->boolean(),
                    'understand' => $faker->numberBetween(1,5),
                    'inspiring' => $faker->numberBetween(1,5),
                    'language_style' => $faker->numberBetween(1,5),
                    'content_flow' => $faker->numberBetween(1,5),
                    'message' => $faker->paragraph(),
                ]);
                $article->feedback()->save($feedback);
            }
        });
    }
}
