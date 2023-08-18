<?php

namespace App\Http\Livewire;

use App\Models\Lesson;
use Illuminate\Support\Arr;
use Livewire\Component;

class SearchModal extends Component
{
    public $input = '';

    public $results = [];

    public $queryResult = '';

    public function updatedInput()
    {
        if (strlen($this->input) > 1) {
            $results = Lesson::search(
                $this->input,
                function ($search, string $query, array $options) {
                    $options['highlightPreTag'] = '<span class="search-hits">';
                    $options['highlightPostTag'] = '</span>';
                    $options['hitsPerPage'] = 20;
                    $options['attributesToHighlight'] = ['title', 'author', 'category'];

                    return $search->search($query, $options);
                }
            )->raw()['hits'];

            $this->results = Arr::map($results, function ($result) {
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

            $this->queryResult = $this->input;
        } else {
            $this->results = [];
            $this->queryResult = $this->input;
        }
    }

    public function resetInput()
    {
        $this->input = '';
        $this->results = [];
        $this->queryResult = '';
    }

    public function render()
    {
        return view('livewire.search-modal');
    }
}
