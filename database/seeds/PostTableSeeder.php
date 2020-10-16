<?php

use App\Helpers\Helper;
use App\Helpers\HeroHelper;
use App\Helpers\VideoHelper;
use App\Models\Article;
use App\Models\Category;
use App\Models\Image as ModelsImage;
use App\Models\Playlist;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $string = file_get_contents("json/posts.json");
        $data = json_decode($string, true);

        foreach($data as $post) {
            if($post['type'] === 'video') {
                $this->playlist($post);
            } else {
                $this->article($post);
            }
        }
    }

    public function hero($name) {
        if($name) {
            $file = Storage::disk('public')->get('old/hero/' . $name);
            $newname = HeroHelper::generate($file);
            return $newname;
        }
        return null;
    }

    public function playlist($post) {
        echo $post['slug'] . " | START ";
        $user = User::find($post['user_id']);

        DB::table('playlists')->insert([
            'id' => $post['id'],
            'minitutor_id' => $user->minitutor->id,
            'category_id' => $post['category_id'],
            'draf' => $post['draf'],
            'slug' => $post['slug'],
            'title' => $post['title'],
            'description' => $post['description'],
            'created_at' => $post['created_at'],
            'updated_at' => $post['updated_at'],
        ]);

        $playlist = Playlist::find($post['id']);
        echo "HERO ";

        $name = $this->hero($post['hero']);
        if($name) {
            $playlist->hero()->save(new ModelsImage([
                'type'=> 'hero',
                'name'=> $name,
                'original_name'=> $post['hero']
            ]));
        }

        $oldVidname = $post['id'] . "_1.mp4";

        if(Storage::disk('public')->exists('fb/' . $oldVidname)) {
            echo "VIDEO ";

            $file = Storage::disk('public')->get('fb/' . $oldVidname);
            $newName = Helper::uniqueName('.mp4');
            Storage::disk('public')->put('videos/' . $newName, $file);

            $last = $playlist->videos()->orderBy('index', 'desc')->first();
            $index = 1;
            if($last) $index = $last->index + 1;
            $video = new Video([
                'name' => $newName,
                'index' => $index,
                'original_name' => $oldVidname
            ]);
            $playlist->videos()->save($video);
        }
        echo "END \n";
    }

    public function article($post) {
        echo $post['slug'] . " | START ";
        $user = User::find($post['user_id']);

        DB::table('articles')->insert([
            'id' => $post['id'],
            'minitutor_id' => $user->minitutor->id,
            'category_id' => $post['category_id'],
            'draf' => $post['draf'],
            'slug' => $post['slug'],
            'title' => $post['title'],
            'description' => $post['description'],
            'body' => $post['body'],
            'created_at' => $post['created_at'],
            'updated_at' => $post['updated_at'],
        ]);

        $article = Article::find($post['id']);
        echo "HERO ";

        $name = $this->hero($post['hero']);
        if($name) {
            $article->hero()->save(new ModelsImage([
                'type'=> 'hero',
                'name'=> $name,
                'original_name'=> $post['hero']
            ]));
        }

        echo "END \n";
    }
}
