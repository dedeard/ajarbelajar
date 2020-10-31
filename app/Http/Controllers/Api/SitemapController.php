<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Minitutor;
use App\Models\Page;
use App\Models\Playlist;

class SitemapController extends Controller
{
    public function playlists()
    {
        $playlists = Playlist::select(['id', 'minitutor_id', 'draf', 'slug'])
        ->whereHas('minitutor', function($q){
            $q->where('active', true);
        })
        ->where('draf', false)
        ->get()
        ->transform(function($item){
            return [
                'id' => $item->id,
                'slug' => $item->slug,
                'created_at' => $item->created_at ? $item->created_at->timestamp : null,
                'updated_at' => $item->updated_at ? $item->updated_at->timestamp : null,
            ];
        });

        return $playlists;
    }
    public function articles()
    {
        $articles = Article::select(['id', 'minitutor_id', 'draf', 'slug'])
        ->whereHas('minitutor', function($q){
            $q->where('active', true);
        })
        ->where('draf', false)
        ->get()
        ->transform(function($item){
            return [
                'id' => $item->id,
                'slug' => $item->slug,
                'created_at' => $item->created_at ? $item->created_at->timestamp : null,
                'updated_at' => $item->updated_at ? $item->updated_at->timestamp : null,
            ];
        });

        return $articles;
    }
    public function categories()
    {
        $categories = Category::select(['id', 'slug'])->withCount([
            'articles' => function($q){
                $q->where('draf', false);
            },
            'playlists' => function($q){
                $q->where('draf', false);
            },
        ])
        ->having('articles_count', '>', 0)
        ->orHaving('playlists_count', '>', 0)
        ->get()
        ->transform(function($item){
            return [
                'id' => $item->id,
                'slug' => $item->slug,
                'created_at' => $item->created_at ? $item->created_at->timestamp : null,
                'updated_at' => $item->updated_at ? $item->updated_at->timestamp : null,
            ];
        });
        return $categories;
    }
    public function minitutors()
    {
        $minitutors = Minitutor::select(['id', 'user_id'])
        ->with(['user' => function($q){
            $q->select('id', 'username');
        }])
        ->where('active', true)
        ->get()
        ->transform(function($item){
            return [
                'id' => $item->id,
                'username' => $item->user->username,
                'created_at' => $item->created_at ? $item->created_at->timestamp : null,
                'updated_at' => $item->updated_at ? $item->updated_at->timestamp : null,
            ];
        });

        return $minitutors;
    }
    public function pages()
    {
        $pages = Page::select('id', 'slug')
        ->where('draf', false)
        ->get()
        ->transform(function($item){
            return [
                'id' => $item->id,
                'slug' => $item->slug,
                'created_at' => $item->created_at ? $item->created_at->timestamp : null,
                'updated_at' => $item->updated_at ? $item->updated_at->timestamp : null,
            ];
        });
        return $pages;
    }
}
