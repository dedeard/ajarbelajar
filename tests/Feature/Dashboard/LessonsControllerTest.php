<?php

namespace Tests\Feature\Dashboard;

use App\Models\Category;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LessonsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index method to view all lessons.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create some lessons for the user (you may need to adjust the data as needed)
        Lesson::factory()->count(10)->create(['user_id' => $user->id]);

        // Send a GET request to the lessons index route
        $response = $this->get(route('dashboard.lessons.index'));

        // Assert that the response has a successful status code
        $response->assertSuccessful();

        // Assert that the view contains the lessons
        $response->assertViewHas('lessons');

        // Assert that the lessons are being paginated
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $response->original->getData()['lessons']);
    }

    /**
     * Test create method to view the create lesson form.
     *
     * @return void
     */
    public function testCreate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Send a GET request to the create lesson route
        $response = $this->get(route('dashboard.lessons.create'));

        // Assert that the response has a successful status code
        $response->assertSuccessful();

        // Assert that the view contains the categories
        $response->assertViewHas('categories');
    }

    /**
     * Test store method to create a new lesson.
     *
     * @return void
     */
    public function testStore()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a category for the lesson
        $category = Category::factory()->create();

        // Data for creating a new lesson
        $data = [
            'title' => 'Test Lesson',
            'category' => $category->id,
            'description' => 'This is a test lesson.',
        ];

        // Send a POST request to store the lesson
        $response = $this->post(route('dashboard.lessons.store'), $data);

        // Assert that the lesson is created successfully
        $response->assertRedirect();
        $this->assertDatabaseHas('lessons', [
            'user_id' => $user->id,
            'title' => $data['title'],
            'category_id' => $data['category'],
            'description' => $data['description'],
        ]);
    }

    /**
     * Test edit method to view the edit lesson form.
     *
     * @return void
     */
    public function testEdit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a lesson for the user (you may need to adjust the data as needed)
        $lesson = Lesson::factory()->create(['user_id' => $user->id]);

        // Send a GET request to the edit lesson route
        $response = $this->get(route('dashboard.lessons.edit', $lesson->id));

        // Assert that the response has a successful status code
        $response->assertSuccessful();

        // Assert that the view contains the lesson
        $response->assertViewHas('lesson', $lesson);

        // Assert that the view contains the categories
        $response->assertViewHas('categories');
    }

    /**
     * Test update method to update a lesson.
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a category for the lesson
        $category = Category::factory()->create();

        // Create a lesson for the user (you may need to adjust the data as needed)
        $lesson = Lesson::factory()->create(['user_id' => $user->id]);

        // Data for updating the lesson
        $data = [
            'title' => 'Updated Lesson',
            'category' => $category->id,
            'public' => 'on', // Check the 'public' checkbox
        ];

        // Send a PUT request to update the lesson
        $response = $this->put(route('dashboard.lessons.update', $lesson->id), $data);

        // Assert that the lesson is updated successfully
        $response->assertRedirect();
        $this->assertDatabaseHas('lessons', [
            'id' => $lesson->id,
            'user_id' => $user->id,
            'title' => $data['title'],
            'category_id' => $data['category'],
            'public' => 1,
        ]);
    }

    /**
     * Test destroy method to delete a lesson.
     *
     * @return void
     */
    public function testDestroy()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a lesson for the user (you may need to adjust the data as needed)
        $lesson = Lesson::factory()->create(['user_id' => $user->id]);

        // Send a DELETE request to delete the lesson
        $response = $this->delete(route('dashboard.lessons.destroy', $lesson->id));

        // Assert that the lesson is deleted successfully
        $response->assertRedirect();
        $this->assertDatabaseMissing('lessons', ['id' => $lesson->id]);
    }

    /**
     * Test updateCover method to update the lesson cover.
     *
     * @return void
     */
    public function testUpdateCover()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a lesson for the user (you may need to adjust the data as needed)
        $lesson = Lesson::factory()->create(['user_id' => $user->id]);

        // Mock the uploaded file
        Storage::fake('public');
        $file = UploadedFile::fake()->image('cover.jpg');

        // Send a POST request to update the lesson cover
        $response = $this->post(route('dashboard.lessons.update.cover', $lesson->id), ['image' => $file]);

        // Assert that the lesson cover is updated successfully
        $response->assertJson($lesson->refresh()->cover_url);
    }

    /**
     * Test updateDescription method to update the lesson description.
     *
     * @return void
     */
    public function testUpdateDescription()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a lesson for the user (you may need to adjust the data as needed)
        $lesson = Lesson::factory()->create(['user_id' => $user->id]);

        // Data for updating the lesson description
        $data = ['description' => 'Updated description'];

        // Send a PUT request to update the lesson description
        $response = $this->put(route('dashboard.lessons.update.description', $lesson->id), $data);

        // Assert that the lesson description is updated successfully
        $response->assertNoContent();
        $this->assertDatabaseHas('lessons', [
            'id' => $lesson->id,
            'description' => $data['description'],
        ]);
    }

    /**
     * Test uploadEpisode method to upload a new episode for a lesson.
     *
     * @return void
     */
    public function testUploadEpisode()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a lesson for the user (you may need to adjust the data as needed)
        $lesson = Lesson::factory()->create(['user_id' => $user->id]);

        // Mock the uploaded file
        Storage::fake('public');
        $file = UploadedFile::fake()->create('video.mp4', 1000); // Create a video file of size 1000 KB

        // Send a POST request to upload the episode
        $response = $this->post(route('dashboard.lessons.store.episode', $lesson->id), ['video' => $file]);

        // Assert that the episode is uploaded successfully
        $response->assertJson(['message' => 'Episode berhasil dibuat']);
        $this->assertDatabaseHas('episodes', [
            'lesson_id' => $lesson->id,
            'seconds' => 0,
        ]);
    }
}
