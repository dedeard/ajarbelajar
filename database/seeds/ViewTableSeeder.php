<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Analytics\AnalyticsFacade;
use Spatie\Analytics\Period;

class ViewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $analyticsData = AnalyticsFacade::performQuery(
            Period::years(1),
            'ga:pageviews',
            [
                'metrics' => 'ga:pageviews',
                'dimensions' => 'ga:pagePathLevel2',
                'sort' => '-ga:pageviews',
                'filters' => 'ga:pagePathLevel1%3D%3D/post/',
            ]
        );
        $data = collect($analyticsData)->transform(function($item){
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

        foreach($data as $item){
            DB::table('playlists')
                ->where('slug', $item['path'])
                ->update(['view_count' => $item['count']]);
            DB::table('articles')
                ->where('slug', $item['path'])
                ->update(['view_count' => $item['count']]);
        }
    }
}
