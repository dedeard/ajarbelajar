<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class VideoHelper
{
    public static function getUrl($name = null)
    {
        if($name) {
            return Storage::temporaryUrl('videos/' . $name, now()->addMinutes(90));
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
