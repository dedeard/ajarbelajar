<?php

namespace App\Helpers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class AvatarHelper extends Helper
{

    /**
     * define constant variable.
     */
    const FORMAT = 'jpg';
    const EXT = '.jpeg';
    const SIZE = 150;
    const QUALITY = 80;
    const DIR = 'avatar/';

    /**
     * Get Disk driver.
     */
    static function disk() : Filesystem
    {
        return Storage::disk('public');
    }

    /**
     * Generate avatar name, upload new avatar delete old avatar.
     */
    static function generate($img, $oldName = null) : String
    {
        if($oldName && self::disk()->exists(self::DIR . $oldName)) {
            self::disk()->delete(self::DIR . $oldName);
        }

        $name = parent::uniqueName(self::EXT);
        $tmp = Image::make($img)->fit(self::SIZE, self::SIZE, function ($constraint) {
            $constraint->aspectRatio();
        });
        self::disk()->put(self::DIR . $name, (string) $tmp->encode(self::FORMAT, self::QUALITY));

        return $name;
    }

    /**
     * Get the avatar url.
     */
    static function getUrl($name) : String
    {
        if($name) return self::disk()->url(self::DIR . $name);
        return asset('img/placeholder/avatar.png');
    }
}
