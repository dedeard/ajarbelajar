<?php

namespace App\Helpers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class CategoryHelper
{
    static function getCategoryOrCreate($str)
    {
        if($str) {
            $category = Category::where('slug', Str::slug($str, '-'));
            if($category->exists()) {
                $category = $category->first();
            } else {
                $category = Category::create([
                    'name' => $str,
                    'slug' => Str::slug($str, '-')
                ]);
                Cache::forget('category');
            }
            return $category;
        }
        return null;
    }

    static function getCategoryIdOrCreate($str)
    {
        $category = self::getCategoryOrCreate($str);
        if($category) return $category->id;
        return null;
    }
}
