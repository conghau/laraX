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

    public static function buildMenus(&$menu_parents, $menu_children, &$dept = 0) {

        foreach ($menu_children as $child) {
            self::buildItem($menu_parents, $child, $dept);
        }
        return $menu_parents;
    }

    private static function buildItem(&$menus, $child, $dept = 0) {
        // is in base array?
        $parent_id = isset($child['parent_id']) ? $child['parent_id'] : 0;
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