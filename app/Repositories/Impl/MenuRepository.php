<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 14/09/2016
 * Time: 10:15
 */

namespace App\Repositories\Impl;

use App\Models\Menu;
use App\Models\MenuNode;
use App\Repositories\Base\BaseRepositoryImpl;
use App\Repositories\MenuRepositoryInterface;
use App\Helpers\LaraXHelper;

/**
 * Class MenuRepository
 *
 * @package App\Repositories
 */
class MenuRepository extends BaseRepositoryImpl implements MenuRepositoryInterface {
    public function __construct(Menu $model) {
        $this->model = $model;
    }

    public function getItems() {
        return $this->model->menuContentNode()->get();
    }

    public function getMenuNodes($menu_content_id, $parent_id = 0, $column = array('*')) {
        return MenuNode::where([
            'menu_content_id' => $menu_content_id,
            'parent_id' => $parent_id
        ])->select($column)->orderBy('position', 'asc')->get();
    }

    public function getMenuNodesChild($menu_content_id, $parent_id = 0, $column = array('*')) {
        return MenuNode::where('menu_content_id', $menu_content_id)
            ->where('parent_id', '!=', $parent_id)
            ->select($column)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function getMenuNodesToArray($menu_content_id, $columns = array('*')) {
        $menu_parent = $this->getMenuNodes($menu_content_id, 0, $columns)->toArray();
        if (is_null($menu_parent)) {
            return NULL;
        }

        $menu_after = array();
        foreach ($menu_parent as $item) {
            $menu_after[$item['id']] = array('value' => (object)$item);
        }

        $menu_child = $this->getMenuNodesChild($menu_content_id, 0, $columns)->toArray();
        if (is_null($menu_child)) {
            return $menu_after;
        }

        $dept = 1;
        LaraXHelper::buildMenus($menu_after, $menu_child, $dept);
        return $menu_after;
    }

    public function getMenuContents($menu_slug, $columns = array('*')) {
        Menu::join('menu_contents', 'menus.id', '=', 'menu_contents.menu_id')
            //            ->join('languages', 'languages.id', '=', 'menu_contents.language_id')
            ->where('menus.slug', '=', $menu_slug)
            //            ->where('menu_contents.language_id', '=', $defaultArgs['languageId'])
            ->select('menus.*', 'menu_contents.id as menu_content_id')->first();
    }
}