<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 03/10/2016
 * Time: 11:32
 */

if (!function_exists('laraX_get_value')) {
  function laraX_get_value($data, $key, $value_default = '') {
    $sub_fields = explode('.', $key);
    foreach ($sub_fields as $k) {
      if (is_array($data)) {
        $data = isset($data[$k]) ? ($data[$k]) : $value_default;
      }
      elseif (is_object($data)) {
        $data = isset($data->{$k}) ? ($data->{$k}) : $value_default;
      }
      else {
        $data = $value_default;
        break;
      }
    }
    return $data;
  }
}

if (!function_exists('laraX_build_button_confirmation')) {
  function laraX_build_button_confirmation($uri_link = '/', $title = '', $more_class = 'blue', $i_class_icon = 'fa fa-check') {
    $output = '<button type="button" data-toggle="confirmation" data-ajax="' . asset($uri_link) . '" class="btn btn-outline btn-sm ajax-link ' . $more_class . '" title="' . $title . '"><i class="' . $i_class_icon . '"></i></button>';
    return $output;
  }
}

if (!function_exists('laraX_build_button')) {
  function laraX_build_button($uri_link = '/', $title = '', $more_class = 'blue', $i_class_icon = 'icon-pencil') {
    $output = '<a href="' . asset($uri_link) . '" class="btn btn-outline btn-sm ' . $more_class . '"><i class="' . $i_class_icon . '" title="' . $title . '"></i></a>';
    return $output;
  }
}

if (!function_exists('laraX_build_url')) {
  function laraX_build_url($path = '/', $is_admin_link = TRUE) {
    if ($is_admin_link) {
      $path = Illuminate\Support\Facades\Config::get('app.admin_path') . '/' . $path;
    }
    return asset($path);
  }
}