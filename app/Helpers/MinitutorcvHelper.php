<?php

namespace App\Helpers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class MinitutorcvHelper extends Helper
{

    /**
     * define constant variable.
     */
    const DIR = 'minitutor/cv/';

    /**
     * Get Disk driver.
     */
    public static function disk(): Filesystem
    {
        return Storage::disk('public');
    }

    /**
     * Generate name and upload.
     */
    public static function generate($file, $oldName = null): String
    {
        $name = parent::uniqueName('.' . $file->extension());
        if ($oldName) {
            self::destroy($oldName);
        }

        self::disk()->put(self::DIR . $name, file_get_contents($file));
        return $name;
    }

    /**
     * Delete file.
     */
    public static function destroy($name): void
    {
        $name = self::DIR . $name;
        if (self::disk()->exists($name)) {
            self::disk()->delete($name);
        }
    }

    /**
     * Get file url.
     */
    public static function getUrl($name): String
    {
        return self::disk()->url(self::DIR . $name);
    }
}
