<?php

namespace Tests\Unit\Helpers;

use App\Helpers\VideoHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VideoHelperTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Set the filesystem disk to use "local" for testing.
        Storage::fake();
    }

    /** @test */
    public function it_can_upload_a_video_and_return_the_file_name()
    {
        // Arrange
        $file = UploadedFile::fake()->create('video.mp4', 10240); // 10 MB file

        // Act
        $fileName = VideoHelper::upload($file);

        // Assert
        Storage::assertExists('episodes/' . $fileName);
    }

    /** @test */
    public function it_can_delete_a_video()
    {
        // Arrange
        $file = UploadedFile::fake()->create('video.mp4', 10240); // 10 MB file
        $fileName = VideoHelper::upload($file);

        // Act
        VideoHelper::destroy($fileName);

        // Assert
        Storage::assertMissing('episodes/' . $fileName);
    }

    /** @test */
    public function it_can_get_the_url_of_a_video()
    {
        // Arrange
        $file = UploadedFile::fake()->create('video.mp4', 10240); // 10 MB file
        $fileName = VideoHelper::upload($file);

        // Act
        $url = VideoHelper::getVideoUrl($fileName);

        // Assert
        $this->assertEquals(Storage::url('episodes/' . $fileName), $url);
    }
}
