<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 14/09/2016
 * Time: 10:26
 */

namespace App\Helpers;

/**
 * Class LarachHelper
 * @package App\Helper
 */
class LarachHelper {
  public static function buildMenu(array $items, $parent_id = 0) {
    $result = NULL;
    foreach ($items as $item) {
      if ($item->parent_id == $parent_id) {
        $result .= "<li class='dd-item nested-list-item' data-order='{$item->order}' data-id='{$item->id}'>
	      <div class='dd-handle nested-list-handle'>
	        <span class='glyphicon glyphicon-move'></span>
	      </div>
	      <div class='nested-list-content'>{
  $item->label}
	        <div class='pull-right'>
	          <a href='
" . url("admin/menu/edit/{$item->id}") . "'>Edit</a> |
	          <a href='#' class='delete_toggle' rel='{$item->id}'>Delete</a>
	        </div>
	      </div>" . self::buildMenu($items, $item->id) . "</li>";
      }
    }
    return $result ? "\n<ol class=\"dd-list\">\n$result</ol>\n" : NULL;
  }
}