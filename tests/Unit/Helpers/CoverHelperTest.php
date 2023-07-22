<?php

namespace Tests\Unit\Helpers;

use App\Helpers\CoverHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Tests\TestCase;

class CoverHelperTest extends TestCase
{
  use RefreshDatabase;

  protected function setUp(): void
  {
    parent::setUp();

    // Set up the necessary configurations for the test
    config(['filesystems.disks.local.root' => storage_path('app/public')]);
  }

  /** @test */
  public function it_generates_cover_images_and_deletes_old_cover()
  {
    // Arrange
    $oldCoverName = 'old_cover_name';
    $fakeImage = Image::canvas(800, 600, '#ff0000'); // Create a fake image for testing
    Storage::fake(); // Use the fake storage for testing

    // Act
    $newCoverName = CoverHelper::generate($fakeImage, $oldCoverName);

    // Assert
    foreach (CoverHelper::SIZES as $key => $size) {
      $newName = CoverHelper::DIR . $newCoverName . '-' . $key . CoverHelper::EXT;
      Storage::assertExists($newName);
      if ($oldCoverName) {
        $oldName = CoverHelper::DIR . $oldCoverName . '-' . $key . CoverHelper::EXT;
        Storage::assertMissing($oldName);
      }
    }
  }

  /** @test */
  public function it_deletes_cover_images()
  {
    // Arrange
    $coverName = 'cover_to_delete';
    Storage::fake();
    foreach (CoverHelper::SIZES as $key => $size) {
      $name = CoverHelper::DIR . $coverName . '-' . $key . CoverHelper::EXT;
      Storage::put($name, 'dummy_content');
    }

    // Act
    CoverHelper::destroy($coverName);

    // Assert
    foreach (CoverHelper::SIZES as $key => $size) {
      $name = CoverHelper::DIR . $coverName . '-' . $key . CoverHelper::EXT;
      Storage::assertMissing($name);
    }
  }

  /** @test */
  public function it_returns_cover_urls()
  {
    // Arrange
    $coverName = 'test_cover';
    Storage::fake();
    foreach (CoverHelper::SIZES as $key => $size) {
      $name = CoverHelper::DIR . $coverName . '-' . $key . CoverHelper::EXT;
      Storage::put($name, 'dummy_content');
    }

    // Act
    $urls = CoverHelper::getUrl($coverName);

    // Assert
    foreach (CoverHelper::SIZES as $key => $size) {
      $expectedUrl = Storage::url(CoverHelper::DIR . $coverName . '-' . $key . CoverHelper::EXT);
      $this->assertEquals($expectedUrl, $urls[$key]);
    }
  }
}
