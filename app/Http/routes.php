<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


/**
 * |--------------------------------------------------------------------------
 * | Admin route - START
 * |--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'cpadmin', 'middleware' => ['web'], 'namespace' => 'App\Http\Controllers\Admin'], function ($router) {

    $router->get('/', 'DashboardController@getIndex');

    $router->controller('auth', 'AuthController');

    /*Settings*/
    $router->controller('settings', 'SettingController');
    /*Menus*/
    $router->controller('menus', 'MenuController');
    /*Post*/
    $router->controller('posts', 'PostController');
    /*Dashboard*/
    $router->controller('dashboard', 'DashboardController');
    /*User*/
    $router->controller('users', 'UserController');
    /*AdminUser*/
    $router->controller('admin-users', 'AdminUserController');
    /*SubscribeEmail*/
    $router->controller('subscribed-emails', 'SubscribeEmailController');
    /*File*/
    $router->controller('files', 'FileController');
    /*File*/
    $router->controller('category', 'CategoryController');
});

/**
 * |--------------------------------------------------------------------------
 * | Admin route - END
 * |--------------------------------------------------------------------------
 */

//Event::listen('illuminate.query',function($query){
//    var_dump($query);
//});

/** API Route */
Route::group(['prefix' => 'api/v1','middleware' => ['api'], 'namespace' => 'App\Http\Controllers\Api'], function () {
    Route::post('login', 'AuthController@login');
    Route::group(['middleware' => 'jwt-auth'], function () {
        Route::post('get_user_details', 'AuthController@get_user_details');
        Route::resource('user', 'UserController');
    });
});

/** API End**/

Route::get('glide/{path}', function($path){
    $server = \League\Glide\ServerFactory::create([
      'source' => app('filesystem')->disk('public')->getDriver(),
      'cache' => storage_path('glide'),
    ]);
    return $server->getImageResponse($path, Input::query());
})->where('path', '.+');
