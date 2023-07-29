<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Helper
{
    /**
     * Generate unique name
     */
    public static function uniqueName(string $ext = ''): string
    {
        return now()->format('hisdmY').Str::random(60).$ext;
    }
}
