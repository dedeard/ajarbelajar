<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class HeroHelper
{

    public static function disk()
    {
        return Storage::disk('public');
    }

    public static function generate($img, $oldName = null)
    {
        $name = self::generateName();
        $format = config('image.hero.format');
        $ext = config('image.hero.extension');
        $dir = config('image.hero.dir');
        if($oldName) self::destroy($oldName);

        foreach(config('image.hero.sizes') as $key => $size) {

            $tmp = Image::make($img)->fit($size['width'], $size['height'], function ($c) {
                $c->aspectRatio();
            });

            $newName = $dir . $name . '-' . $key . $ext;
            self::disk()->put($newName, (string) $tmp->encode($format, $size['quality']));
        }

        return $name;
    }

    public static function destroy($name)
    {
        $ext = config('image.hero.extension');
        $dir = config('image.hero.dir');

        foreach(config('image.hero.sizes') as $key => $size) {
            $newName = $dir . $name . '-' . $key . $ext;
            if(self::disk()->exists($newName)) {
                self::disk()->delete($newName);
            }
        }
    }

    public static function getUrl($name)
    {
        $ext = config('image.hero.extension');
        $dir = config('image.hero.dir');

        $urls = [];

        foreach(config('image.hero.sizes') as $key => $size) {
            if($name) {
                $newName = $dir . $name . '-' . $key . $ext;
                $urls[$key] = self::disk()->url($newName);
            } else {
                $urls[$key] = asset('/img/placeholder/hero-' . $key . '.jpg');
            }
        }
        return $urls;
    }

    public static function generateName()
    {
        return now()->format('hisdmY') . Str::random(60);
    }

}
