<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class AvatarHelper {

  /**
   * Generate avatar
   *
   */
  public static function generateAvatar($img, $oldName = null)
  {
    $name = self::generateName();

    if($oldName) self::destroy(config('image.avatar.dir') . $oldName);

    $tmp = Image::make($img)->fit(config('image.avatar.size'), config('image.avatar.size'), function ($constraint) {
      $constraint->aspectRatio();
    });

    Storage::put(config('image.avatar.dir') . $name, (string) $tmp->encode(config('image.avatar.format'), config('image.avatar.quality')));

    return $name;
  }

  /**
   * Get the avatar url
   *
   */
  public static function getAvatarUrl($name)
  {
    if($name) {
      return Storage::url(config('image.avatar.dir') . $name);
    }
    return asset('img/placeholder/avatar.png');
  }

  /**
   * Generate unique name
   *
   */
  public static function generateName()
  {
    return now()->format('hisdmY') . Str::random(60) . '.' . config('image.avatar.extension');
  }

  /**
   * Destroy the avatar
   *
   */
  public static function destroy($name)
  {
    $name = config('image.avatar.dir') . $name;
    if(Storage::exists($name)) Storage::delete($name);
  }
}
