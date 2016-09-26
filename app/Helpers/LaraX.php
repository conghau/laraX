<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 14/09/2016
 * Time: 10:26
 */

namespace App\Helpers;

/**
 * Class LaraXHelper
 *
 * @package App\Helper
 */
class LaraXHelper {
//    public static function buildMenu(array $items, $parent_id = 0) {
//        $result = NULL;
//        foreach ($items as $item) {
//            if ($item->parent_id == $parent_id) {
//                $result .= "<li class='dd-item nested-list-item' data-order='{$item->order}' data-id='{$item->id}'>
//	      <div class='dd-handle nested-list-handle'>
//	        <span class='glyphicon glyphicon-move'></span>
//	      </div>
//	      <div class='nested-list-content'>{
//  $item->label}
//	        <div class='pull-right'>
//	          <a href='
//" . url("admin/menu/edit/{$item->id}") . "'>Edit</a> |
//	          <a href='#' class='delete_toggle' rel='{$item->id}'>Delete</a>
//	        </div>
//	      </div>" . self::buildMenu($items, $item->id) . "</li>";
//            }
//        }
//        return $result ? "\n<ol class=\"dd-list\">\n$result</ol>\n" : NULL;
//    }

    public static function buildMenus(&$menu_parents, $menu_children, &$dept = 0) {

        foreach ($menu_children as $child) {
            self::buildItem($menu_parents, $child, $dept);
        }
        return $menu_parents;
    }

    private static function buildItem(&$menus, $child, $dept = 0) {
        // is in base array?
        $parent_id = isset($child['parent_id']) ? $child['parent_id']: 0;
        if (array_key_exists($parent_id, $menus)) {
            if (!array_key_exists('child', $menus[$parent_id])) {
                $menus[$parent_id]['child'] = [];
            }
            $menus[$parent_id]['child'][$child['id']] = array('value' => (object)$child);
            return TRUE;
        }

        // check arrays contained in this array
        foreach ($menus as &$element) {
            if (is_array($element)) {
                if (self::buildItem($element, $child, $dept)) {
                    $dept += 1;
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    public function check_parent_exist(&$menus, $child, &$dept = 0) {
        // is in base array?
        if (array_key_exists($child['parent_id'], $menus)) {
            $parent_id = $child['parent_id'];
            if (!array_key_exists('child', $menus[$parent_id])) {
                $menus[$parent_id]['child'] = [];
            }
            $menus[$parent_id]['child'][$child['id']] = array('value' => (object)$child);
            return TRUE;
        }

        // check arrays contained in this array
        foreach ($menus as &$element) {
            if (is_array($element)) {
                if ($this->check_parent_exist($element, $child, $dept)) {
                    $dept += 1;
                    return TRUE;
                }
            }
        }
        return FALSE;
    }
}