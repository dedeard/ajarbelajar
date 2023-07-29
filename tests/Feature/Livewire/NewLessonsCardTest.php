<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\NewLessonsCard;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NewLessonsCardTest extends TestCase
{
    use RefreshDatabase;

    public function testNewLessonsCardRendersCorrectly()
    {
        // Create lessons and a lesson to ignore
        $lessons = Lesson::factory()->count(4)->create(['public' => true]);

        // Livewire test: render the NewLessonsCard component and pass the ignoreId data
        Livewire::test(NewLessonsCard::class, ['ignoreId' => $lessons[0]->id])
            ->assertDontSee($lessons[0]->title) // Assert that the component renders the title of the first lesson
            ->assertSee($lessons[1]->title) // Assert that the component renders the title of the second lesson
            ->assertSee($lessons[2]->title) // Assert that the component renders the title of the third lesson
            ->assertSee($lessons[3]->title); // Assert that the lesson to ignore is not rendered in the component
    }
}
