<?php

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $string = file_get_contents("json/post_reviews.json");
        $data = json_decode($string, true);
        $feedbacks = [];
        foreach($data as $feedback) {

            $article = Article::find($feedback['post_id']);
            if($article) {
                $target = "App\Models\Article";
            } else {
                $target = "App\Models\Playlist";
            }

            array_push($feedbacks, [
                "id" => $feedback['id'],
                "user_id" => $feedback['user_id'],
                "feedbackable_id" => $feedback['post_id'],
                "feedbackable_type" => $target,
                "sync_with_me" => $feedback['sync_with_me'],
                "understand" => $feedback['understand'],
                "inspiring" => $feedback['inspiring'],
                "language_style" => $feedback['language_style'],
                "content_flow" => $feedback['content_flow'],
                "message" => $feedback['message'],
                'created_at' => $feedback['created_at'],
                'updated_at' => $feedback['updated_at'],
            ]);
        }
        DB::table('feedback')->insert($feedbacks);
    }
}
