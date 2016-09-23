<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 23/09/2016
 * Time: 15:30
 */

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use TCH\TCHMenu;

class TCHServiceProvider extends ServiceProvider {

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register() {
    $this->app->bind('TCHMenu', function ($app) {
      return $this->app->make(TCHMenu::class);
    });
  }
}