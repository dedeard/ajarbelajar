<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $input = $request->input('search', '');
        $results = [];

        if (strlen($input) > 1) {
            $response = Lesson::search(
                $input,
                function ($search, string $query, array $options) {
                    $options['highlightPreTag'] = '<span class="search-hits">';
                    $options['highlightPostTag'] = '</span>';
                    $options['hitsPerPage'] = 20;
                    $options['attributesToHighlight'] = ['title', 'author', 'category'];
                    return $search->search($query, $options);
                }
            )->raw()['hits'];

            $results = Arr::map($response, function ($result) {
                if (config('scout.driver') === 'algolia') {
                    $result['title'] = $result['_highlightResult']['title']['value'];
                    $result['author'] = $result['_highlightResult']['author']['value'];
                    $result['category'] = $result['_highlightResult']['category']['value'];
                } else if (config('scout.driver') === 'meilisearch') {
                    $result['title'] = $result['_formatted']['title'];
                    $result['author'] = $result['_formatted']['author'];
                    $result['category'] = $result['_formatted']['category'];
                }
                return $result;
            });
        }

        return response()->json(['results' => $results, 'input' => $input]);
    }
}
