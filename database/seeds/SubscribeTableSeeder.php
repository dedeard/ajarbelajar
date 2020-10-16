<?php

use App\Models\Article;
use App\Models\Playlist;
use App\Models\Minitutor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscribeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $string = file_get_contents("json/followables.json");
        $data = json_decode($string, true);
        foreach($data as $snap) {
            if($snap['relation'] === 'favorite') {
                $this->favorite($snap);
            }
            if($snap['relation'] === 'subscribe') {
                $this->subscribe($snap);
            }
        }
    }

    public function subscribe($data) {
        if(Minitutor::find($data["followable_id"])) {
            DB::table('subscriptions')->insert([
                "subscribable_type" => "App\Models\Minitutor",
                "subscribable_id" => $data["followable_id"],
                "user_id" => $data['user_id'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]);
        }
    }

    public function favorite($data) {
        $article = Article::find($data['followable_id']);
        if($article) {
            $target = "App\Models\Article";
            if(empty(Article::find($data['followable_id']))) {
                return 1;
            }
        } else {
            $target = "App\Models\Playlist";
            if(empty(Playlist::find($data['followable_id']))) {
                return 1;
            }
        }
        DB::table('subscriptions')->insert([
            "subscribable_type" => $target,
            "subscribable_id" => $data["followable_id"],
            "user_id" => $data['user_id'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at'],
        ]);
    }
}
