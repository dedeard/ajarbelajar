<?php

use App\Models\Article;
use App\Models\Comment;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $article = Article::findOrFail(1);
        for($i = 1; $i < 20; $i++) {
            $comment = new Comment([
                'user_id' => $faker->numberBetween(1,3),
                'body' => $faker->paragraph(),
                'public' => true
            ]);
            $article->comments()->save($comment);
            $comment = new Comment([
                'user_id' => $faker->numberBetween(1,3),
                'body' => $faker->paragraph(),
                'public' => false
            ]);
            $article->comments()->save($comment);
        }
    }
}
