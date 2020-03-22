<?php

namespace App\Helpers;

use App\Model\Seo as ModelSeo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Artesaos\SEOTools\Facades\SEOMeta;

class Seo
{
  public static function all()
  {
    return Cache::rememberForever('seo', function () {
      return ModelSeo::all();
    });
  }

  public static function one($name)
  {
    return Arr::first(self::all()->toArray(), function ($value) use($name) {
      if($value['name'] === $name) return true;
      return false;
    });
  }

  public static function set($name)
  {
    SEOMeta::setTitle(self::one($name)['title']);
    SEOMeta::setDescription(self::one($name)['description']);
    SEOMeta::addKeyword(self::one($name)['keywords']);
    SEOMeta::setRobots(self::one($name)['robots']);
  }
}
