<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 23/09/2016
 * Time: 16:22
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class TCHMenu extends Facade {
  protected static function getFacadeAccessor() {
    return 'LaraXMenu';
  }
}