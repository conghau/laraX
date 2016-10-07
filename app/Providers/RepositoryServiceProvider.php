<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 9/17/2016
 * Time: 4:50 AM
 */

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        foreach ($this->models as $model) {
            $this->app->bind(
                "App\\Repositories\\{$model}RepositoryInterface",
                "App\\Repositories\\Impl\\{$model}Repository"
            );
        }
    }

    protected $models = ['Setting', 'Menu', 'Post', 'Language', 'Country', 'City'];
}