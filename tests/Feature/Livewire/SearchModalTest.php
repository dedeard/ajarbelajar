<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\SearchModal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SearchModalTest extends TestCase
{
    use RefreshDatabase;

    public function testSearchModalRendersCorrectly()
    {
        Livewire::test(SearchModal::class)
            ->assertStatus(200);
    }

    public function testSearchModalUpdatesResultsWhenInputIsShort()
    {
        // Livewire test: render the SearchModal component
        Livewire::test(SearchModal::class)
            ->set('input', 'S') // Input is less than 2 characters
            ->assertSet('results', []) // Results should be empty
            ->assertSet('queryResult', 'S'); // Query result should still be updated
    }
}
