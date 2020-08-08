<?php

use App\Models\Minitutor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $minitutors = Minitutor::select(['id', 'user_id'])->get();
        foreach($minitutors as $minitutor) {
            $posts = $minitutor->posts()->select(['id'])->with(['reviews' => function($q){
                return $q->select(['post_id', DB::raw('(understand + inspiring + language_style + content_flow)/4 as rating')]);
            }])->get();
            $point = 0;
            foreach($posts as $post){
                $point += 25;
                $comments = $post->comments()->select(['id', 'user_id', 'post_id', 'approved'])->where('approved', 1)->count();
                $point += (4*$comments);

                foreach($post->reviews as $review) {
                    $point += round($review->rating*4);
                }
            }
            $minitutor->user->points = $point;
            $minitutor->user->save();
        }
    }
}
