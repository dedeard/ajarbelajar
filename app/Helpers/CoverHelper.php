<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class CoverHelper
{
    // Define image format and extension constant variables.
    const IMAGE_FORMAT = 'jpg';
    const IMAGE_EXTENSION = '.jpeg';
    const DIRECTORY = 'cover/';

    // Image sizes configuration.
    const IMAGE_SIZES = [
        'large' => ['width' => 1024, 'height' => 576, 'quality' => 75],
        'thumb' => ['width' => 320, 'height' => 180, 'quality' => 75],
        'small' => ['width' => 64, 'height' => 36, 'quality' => 85],
        'blur' => ['width' => 16, 'height' => 9, 'quality' => 20],
    ];

    /**
     * Generate cover images, upload new cover, and delete old cover.
     *
     * @param string $imageData The image data to be processed.
     *
     * @return array An array containing URLs of generated cover images.
     */
    public static function generateCoverImages($imageData): array
    {
        $coverUrls = [];

        foreach (self::IMAGE_SIZES as $sizeKey => $size) {
            // Resize the image based on the size configuration.
            $resizedImage = Image::make($imageData)->fit($size['width'], $size['height'], function ($constraint) {
                $constraint->aspectRatio();
            });

            // Generate a new name for the resized image.
            $newCoverName = self::DIRECTORY . Str::uuid() . self::IMAGE_EXTENSION;

            // Store the resized image in storage with specified quality.
            Storage::put($newCoverName, (string) $resizedImage->encode(self::IMAGE_FORMAT, $size['quality']));

            // Store the URL of the resized image.
            $coverUrls[$sizeKey] = Storage::url($newCoverName);
        }

        return $coverUrls;
    }

    /**
     * Get the URLs of placeholder cover images.
     *
     * @return array An array containing URLs of placeholder cover images.
     */
    public static function getPlaceholderUrls(): array
    {
        $placeholderUrls = [];
        foreach (self::IMAGE_SIZES as $sizeKey => $size) {
            // Generate the URL of the placeholder image based on the key.
            $placeholderUrls[$sizeKey] = asset('/img/placeholder/cover-' . $sizeKey . '.jpg');
        }

        return $placeholderUrls;
    }
}
