<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoHelper
{
    /**
     * define constant variable.
     */
    const DIR = 'episodes/';

    /**
     * Generate name and upload.
     */
    public static function upload($data): string
    {
        $name = str::uuid() . '.' . $data->guessClientExtension();
        Storage::put(self::DIR . $name, file_get_contents($data->getRealPath()));

        return $name;
    }

    /**
     * Delete video.
     */
    public static function destroy($name): void
    {
        if ($name) {
            Storage::delete(self::DIR . $name);
            Storage::delete(Storage::allFiles(self::DIR . $name));
        }
    }

    /**
     * Get m3u8 playlist url.
     */
    public static function getM3u8PlaylistUrl($name): string
    {
        return Storage::url(self::DIR . $name . '/playlist.m3u8');
    }

    /**
     * Get video url.
     */
    public static function getVideoUrl($name): string
    {
        return Storage::url(self::DIR . $name);
    }
}
