<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MinitutorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $string = file_get_contents("json/minitutors.json");
        $data = json_decode($string, true);
        $minitutors = [];
        foreach($data as $minitutor) {
            array_push($minitutors, [
                'id' => $minitutor['id'],
                'user_id' => $minitutor['user_id'],
                'active' => $minitutor['active'],
                'last_education' => $minitutor['last_education'],
                'university' => $minitutor['university'],
                'city_and_country_of_study' => $minitutor['city_and_country_of_study'],
                'majors' => $minitutor['majors'],
                'interest_talent' => $minitutor['interest_talent'],
                'contact' => $minitutor['contact'],
                'expectation' => $minitutor['expectation'],
                'reason' => $minitutor['reason'],
                'created_at' => $minitutor['created_at'],
                'updated_at' => $minitutor['updated_at'],
            ]);
        }
        DB::table('minitutors')->insert($minitutors);
    }
}
