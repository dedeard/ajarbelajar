<?php

namespace App\Helpers;

use App\Models\Image as ModelsImage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FroalaHelper extends Helper
{

    /**
     * define constant variable.
     */
    const FORMAT = 'jpg';
    const EXT = '.jpeg';
    const DIR = 'pages/';

    /**
     * Get Disk driver.
     */
    static function disk(): Filesystem
    {
        return Storage::disk('public');
    }

    /**
     * Uploading the image and get name, relative url.
     */
    static function uploadImage($data): array
    {
        $format = self::FORMAT;
        $dir = self::DIR;
        $ext = self::EXT;
        $name = parent::uniqueName($ext);

        $tmp = Image::make($data)->resize(640, 640, function ($constraint) {
            $constraint->aspectRatio();
        });
        self::disk()->put($dir . $name, (string) $tmp->encode($format, 80));

        return ['name' => $name, "url" => self::disk()->url("{$dir}{$name}")];
    }

    /**
     * Deleting the image.
     */
    static function deleteImage($url): void
    {
        $name = Str::replaceFirst(self::disk()->url(self::DIR), '', $url);
        ModelsImage::where('imageable_type', 'froala')->where('name', $name)->firstOrFail()->delete();
        if (self::disk()->exists(self::DIR . $name)) {
            self::disk()->delete(self::DIR . $name);
        }
    }

    /**
     * Generate the image url.
     */
    static function generateUrl($name): String
    {
        return self::disk()->url(self::DIR . $name);
    }
}
