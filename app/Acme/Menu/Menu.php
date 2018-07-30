<?php 

namespace Acme\Menu;

use Illuminate\Support\Collection;

class Menu
{
  public function active($item, $current)
  {
    if ($item == $current) {
      return 'open active';
    }
  }
}