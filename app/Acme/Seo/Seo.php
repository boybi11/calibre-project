<?php 

namespace Acme\Seo;

use Illuminate\Support\Collection;
use App\Option;
use App\Asset;

class Seo
{
  public function get($object)
  {
    $seo = $object->seo->first();
    $asset = Asset::findOrFail($seo->image);

    $response = [];
    $response['title'] = $seo->title;
    $response['description'] = $seo->description;
    $response['image'] = $asset->path;

    return $response;
  }

  public function title($value)
  {
    $option = Option::whereSlug('meta-title')->first();
    $response = ($value) ? $value : $option->value;

    return $response;
  }

  public function description($value)
  {
    $option = Option::whereSlug('meta-description')->first();
    $response = ($value) ? $value : $option->value;
    
    return $response;
  }
}