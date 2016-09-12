<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 12/09/2016
 * Time: 16:18
 */
// Select a name for your theme
return array(
  'zara' => [

    /*
    |--------------------------------------------------------------------------
    | Theme to extend. Defaults to null (=none)
    |--------------------------------------------------------------------------
    */
    'extends' => null,

    /*
    |--------------------------------------------------------------------------
    | The path where the view are stored. Defaults to 'theme-name'
    | It is relative to 'themes_path' ('/resources/views' by default)
    |--------------------------------------------------------------------------
    */
    'views-path' => '/public/themes/zara/views',

    /*
    |--------------------------------------------------------------------------
    | The path where the assets are stored. Defaults to 'theme-name'
    | It is relative to laravels public folder (/public)
    |--------------------------------------------------------------------------
    */
    'asset-path' => '/public/',

    /*
    |--------------------------------------------------------------------------
    | Custom configuration. You can add your own custom keys.
    | Retrieve these values with Theme::config('key'). e.g.:
    |--------------------------------------------------------------------------
    */
    'key' => 'value',
  ],
);