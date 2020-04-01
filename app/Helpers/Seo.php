<?php

namespace App\Helpers;

use App\Model\Seo as ModelSeo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\TwitterCard;

class Seo
{
  public static function all()
  {
    return Cache::rememberForever('seo', function () {
      return ModelSeo::all();
    });
  }

  public static function one($path)
  {
    return Arr::first(self::all()->toArray(), function ($value) use($path) {
      if($value['path'] === $path) return true;
      return false;
    });
  }

  public static function set($path)
  {
    $data = self::one($path);
    if(!$data) return 0;
    SEOMeta::setTitle($data['title']);
    SEOMeta::setDescription($data['description']);
    SEOMeta::setRobots($data['robots']);

    OpenGraph::setDescription($data['description']);
    OpenGraph::setTitle($data['title']);
    OpenGraph::setUrl(url()->current());
    OpenGraph::addProperty('type', $data['type']);

    TwitterCard::setTitle($data['title']);
    TwitterCard::setSite('@ajarbelajar');

    JsonLd::setTitle($data['title']);
    JsonLd::setDescription($data['description']);
    JsonLd::addImage(asset('img/logo/logo.svg'));
  }
}
