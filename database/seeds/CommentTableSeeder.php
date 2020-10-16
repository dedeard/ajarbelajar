<?php

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $string = file_get_contents("json/post_comments.json");
        $data = json_decode($string, true);
        $comments = [];
        foreach($data as $comment) {

            $article = Article::find($comment['post_id']);
            if($article) {
                $target = "App\Models\Article";
                $type = "article";
            } else {
                $target = "App\Models\Playlist";
                $type = "playlist";
            }

            array_push($comments, [
                "id" => $comment['id'],
                "user_id" => $comment['user_id'],
                "commentable_id" => $comment['post_id'],
                "commentable_type" => $target,
                "body" => $comment['body'],
                "public" => $comment['approved'],
                "type" => $type,
                'created_at' => $comment['created_at'],
                'updated_at' => $comment['updated_at'],
            ]);
        }
        DB::table('comments')->insert($comments);
    }
}
