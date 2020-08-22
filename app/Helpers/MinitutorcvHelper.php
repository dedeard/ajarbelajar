<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MinitutorcvHelper
{
    public const REQUEST_DIR = 'request_minitutor/cv/';
    public const ACCEPTED_DIR = 'minitutor/cv/';

    public static function generateRequest($file, $oldName = null) : String
    {
        $name = Str::random(60) . '.' . $file->extension();
        if($oldName) self::destroyRequest($oldName);
        Storage::put(self::REQUEST_DIR . $name, file_get_contents($file));
        return $name;
    }

    public static function destroyRequest($name) : void
    {
        $name = self::REQUEST_DIR . $name;
        if(Storage::exists($name)) Storage::delete($name);
    }

    public static function getRequestUrl($name) : String
    {
        return Storage::url(self::REQUEST_DIR . $name);
    }

    public static function moveToAccepted($name) : void
    {
        if(Storage::exists(self::REQUEST_DIR . $name)) {
            Storage::move(self::REQUEST_DIR . $name, self::ACCEPTED_DIR . $name);
        }
    }

    public static function destroyAccepted($name) : void
    {
        $name = self::ACCEPTED_DIR . $name;
        if(Storage::exists($name)) Storage::delete($name);
    }

    public static function getAcceptedUrl($name) : String
    {
        return Storage::url(self::ACCEPTED_DIR . $name);
    }
}
