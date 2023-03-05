<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class VideoHelper extends Helper
{
    /**
     * define constant variable.
     */
    const DIR = 'episodes/';

    /**
     * Generate name and upload.
     */
    public static function upload($data, $oldName = null): string
    {
        $name = parent::uniqueName('.' . $data->extension());
        if ($oldName) {
            self::destroy($oldName);
        }
        Storage::put(self::DIR . $name, file_get_contents($data->getRealPath()));
        return $name;
    }

    /**
     * Delete video.
     */
    public static function destroy($name): void
    {
        if ($name && Storage::exists(self::DIR . $name)) {
            Storage::delete(self::DIR . $name);
        }
    }

    /**
     * Get video url.
     */
    public static function getUrl($name): string
    {
        return $name ? Storage::url(self::DIR . $name) : '';
    }
}
