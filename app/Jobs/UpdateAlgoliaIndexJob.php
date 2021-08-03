<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Algolia\AlgoliaSearch\SearchClient;
use App\Models\Post;

class UpdateAlgoliaIndexJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = SearchClient::create(env('ALGOLIA_APP_ID'), env('ALGOLIA_API_KEY'));
        $index = $client->initIndex(env('ALGOLIA_POSTS_INDEX'));

        $data = Post::select('id', 'title', 'slug', 'hero', 'type', 'minitutor_id')->with(['minitutor' => function($q){
            $q->select('id', 'user_id', 'active')->with(['user' => function($q){
                $q->select('id', 'name');
            }]);
        }])
        ->whereHas('minitutor', function ($q) {
            $q->where('active', true);
        })
        ->whereNotNull('posted_at')
        ->get()
        ->map(function($el){
            return [
                'objectID' => 'postID-' . $el->id,
                'type' => $el->type,
                'slug' => $el->slug,
                'title' => $el->title,
                'hero' => $el->heroUrl['small'] ? $el->heroUrl['small'] : null,
                'name' => $el->minitutor->user->name,
            ];
        });

        $index->replaceAllObjects($data->toArray(), ['safe' => true]);
    }
}
