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