<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Playlist;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Cache::remember('searching', 60 * 30, function () {
            $union = Article::select(['id', 'minitutor_id', 'draf', 'slug', 'title', 'created_at', DB::raw("'Article' as type")])
            ->with(['hero', 'minitutor' => function($q){
                $q->select(['id', 'user_id', 'active']);
                $q->with(['user' => function($q) {
                    $q->select(['id', 'name']);
                }]);
            }])
            ->whereHas('minitutor', function($q){
                $q->where('active', true);
            })
            ->where('draf', false);

            return Playlist::select(['id', 'minitutor_id', 'draf', 'slug', 'title', 'created_at', DB::raw("'Playlist' as type")])
            ->with(['hero', 'minitutor' => function($q){
                $q->select(['id', 'user_id', 'active']);
                $q->with(['user' => function($q) {
                    $q->select(['id', 'name']);
                }]);
            }])
            ->whereHas('minitutor', function($q){
                $q->where('active', true);
            })
            ->where('draf', false)
            ->union($union)
            ->get()
            ->transform(function($item){
                return [
                    'type' => $item->type,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'created_at' => $item->created_at->timestamp,
                    'img' => $item->hero_url ? $item->hero_url['small'] : null,
                    'name' => $item->minitutor->user->name
                ];
            });
        });

        return ['data' => $data];
    }
}
