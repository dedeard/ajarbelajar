<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Helper
{
    /**
     * Generate unique name
     */
    static function uniqueName(String $ext = '') : String
    {
        return now()->format('hisdmY') . Str::random(60) . $ext;
    }
}
