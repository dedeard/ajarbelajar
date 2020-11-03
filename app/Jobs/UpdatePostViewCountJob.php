<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Analytics\AnalyticsFacade;
use Spatie\Analytics\Period;

class UpdatePostViewCountJob implements ShouldQueue
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
        echo "start view count \n";
        $startDate = Carbon::create('2020', '02');
        $endDate = Carbon::create('2020', '11');
        $priod = Period::create($startDate, $endDate);

        $analyticsData = AnalyticsFacade::performQuery(
            $priod,
            'ga:pageviews',
            [
                'metrics' => 'ga:pageviews',
                'dimensions' => 'ga:pagePathLevel2',
                'sort' => '-ga:pageviews',
                'filters' => 'ga:pagePathLevel1%3D%3D/post/',
                'max-results' => '1000'
            ]
        );
        $oldData = collect($analyticsData)->transform(function($item){
            $path = trim($item[0], '/');
            $path = explode('?', $path)[0];
            return [
                'path' => $path,
                'count' => $item[1],
            ];
        })->groupBy('path')->map(function ($row) {
            return $row->sum('count');
        })->transform(function($val, $key){
            return [
                'path' => $key,
                'count' => $val,
            ];
        })->values()->all();

        foreach($oldData as $item){
            try {
                DB::table('playlists')
                    ->where('slug', $item['path'])
                    ->update(['view_count' => $item['count']]);
                DB::table('articles')
                    ->where('slug', $item['path'])
                    ->update(['view_count' => $item['count']]);
            } catch (\Exception $e) {
                continue;
            }
        }

        $startDate = Carbon::create('2020', '10');
        $endDate = Carbon::now();
        $priod = Period::create($startDate, $endDate);

        $analyticsData = AnalyticsFacade::performQuery(
            $priod,
            'ga:pageviews',
            [
                'metrics' => 'ga:pageviews',
                'dimensions' => 'ga:pagePathLevel1,ga:pagePathLevel2',
                'sort' => '-ga:pageviews',
                'filters' => 'ga:pagePathLevel1%3D%3D/playlists/,ga:pagePathLevel1%3D%3D/articles/',
                'max-results' => '1000'
            ]
        );

        $newData = collect($analyticsData)
        ->transform(function($item){
            $table = Str::lower(trim($item[0], '/'));
            $slug = Str::lower(trim($item[1], '/'));
            $slug = explode('?', $slug)[0];

            return [
                'table' => $table,
                'slug' => $slug,
                'count' => $item[2],
            ];
        })
        ->filter(function ($row) {
            return ($row['slug'] != '' && ($row['table'] == 'articles' || $row['table'] == 'playlists'));
        })
        ->sortBy('count')
        ->toArray();


        foreach($newData as $item){
            try {
                DB::table($item['table'])
                    ->where('slug', $item['slug'])
                    ->update(['view_count' => DB::raw("view_count + {$item['count']}")]);
            } catch (\Exception $e) {
                continue;
            }
        }
    }
}
