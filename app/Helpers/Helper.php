<?php

namespace App\Helpers;

use Str;

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
