<?php
namespace App\Lib;
use Storage;
class ImageManipulation
{
  public static $thumbnail_suffix = "_thumb";
  public static function thumbnailName($path)
  {
    return $path.self::$thumbnail_suffix;
  }
  public static function createThumbnail($path)
  {
    $final_path = static::thumbnailName($path);
    if(!Storage::exists($final_path))
    {
      $thumb = \Image::make($path);
      $thumb->fit(200,200);
      $thumb->save($final_path);
    }
    return $final_path;
  }

}
