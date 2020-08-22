<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoHelper
{
    public static function generate($data)
    {
        $name = self::generateName($data->extension());
        Storage::put('videos/' . $name, file_get_contents($data));
        return $name;
    }

    public static function generateName($ext)
    {
        return now()->format('hisdmY') . Str::random(60) . '.' . $ext;
    }

    public static function getUrl($name = null)
    {
        if($name) {
            return Storage::url('videos/' . $name);
        }
        return '';
    }

    public static function destroy($name = null)
    {
        if($name) {
            if(Storage::exists('videos/' . $name))
                Storage::delete('videos/' . $name);
        }
    }
}
