<?php

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $string = file_get_contents("json/post_views.json");
        $data = json_decode($string, true);
        foreach($data as $view) {

            $article = Article::find($view['post_id']);
            if($article) {
                $target = "App\Models\Article";
            } else {
                $target = "App\Models\Playlist";
            }

            DB::table('views')->insert([
                "id" => $view['id'],
                "viewable_id" => $view['post_id'],
                "viewable_type" => $target,
                "ip" => $view['ip'],
                "agent" => $view['agent'],
                'created_at' => $view['created_at'],
                'updated_at' => $view['updated_at'],
            ]);
        }
    }
}
