<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesControllerTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Test index method to view categories with public lessons.
   *
   * @return void
   */
  public function testIndex()
  {
    // Create a category with a public lesson
    $category = Category::factory()->create();
    Lesson::factory()->create(['category_id' => $category->id, 'public' => true]);

    // Send a GET request to the categories index route
    $response = $this->get(route('categories.index'));

    // Assert that the response has a successful status code
    $response->assertSuccessful();

    // Assert that the categories are being displayed on the view
    $response->assertViewHas('categories');

    // Assert that the categories contain the created category
    $response->assertSee($category->name);
  }

  /**
   * Test show method to view lessons in a specific category.
   *
   * @return void
   */
  public function testShow()
  {
    // Create a category with lessons (you may need to adjust the data as needed)
    $category = Category::factory()->create();
    $lessons = Lesson::factory()->count(5)->create(['category_id' => $category->id, 'public' => true]);

    // Send a GET request to the category show route
    $response = $this->get(route('categories.show', ['category' => $category->slug]));

    // Assert that the response has a successful status code
    $response->assertSuccessful();

    // Assert that the lessons are being displayed on the view
    $response->assertViewHas('lessons');

    // Assert that the lessons belong to the created category
    $response->assertSee($category->name);

    // Assert that each lesson's title is being displayed on the view
    foreach ($lessons as $lesson) {
      $response->assertSee($lesson->title);
    }
  }

  /**
   * Test show method to view lessons in a specific category with different sorting options.
   *
   * @return void
   */
  public function testShowWithSorting()
  {
    // Create a category with lessons (you may need to adjust the data as needed)
    $category = Category::factory()->create();
    Lesson::factory()->count(5)->create(['category_id' => $category->id, 'public' => true]);

    // Test sorting by newest (default)
    $byDefault = $this->get(route('categories.show', ['category' => $category->slug]));
    $byDefault->assertSuccessful();
    $byDefault->assertViewHas('lessons');
    $byDefault->assertViewHas('sort', null);

    // Test sorting by oldest
    $byOldest = $this->get(route('categories.show', ['category' => $category->slug, 'sort' => 'oldest']));
    $byOldest->assertSuccessful();
    $byOldest->assertViewHas('lessons');
    $byOldest->assertViewHas('sort', 'oldest');

    // Test sorting by popularity
    $byPopularity = $this->get(route('categories.show', ['category' => $category->slug, 'sort' => 'popularity']));
    $byPopularity->assertSuccessful();
    $byPopularity->assertViewHas('lessons');
    $byPopularity->assertViewHas('sort', 'popularity');


    // Test sorting by wrong
    $byPopularity = $this->get(route('categories.show', ['category' => $category->slug, 'sort' => 'wrong']));
    $byPopularity->assertStatus(404);
  }
}
