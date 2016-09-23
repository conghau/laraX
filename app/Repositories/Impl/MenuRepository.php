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

/**
 * Class MenuRepository
 * @package App\Repositories
 */
class MenuRepository extends BaseRepositoryImpl implements MenuRepositoryInterface {
//    protected $model = 'App\Models\Menu';
  public function __construct(Menu $model) {
    $this->model = $model;
  }

  public function getItems() {
//        $this->model->leftjoin
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
      ->orderBy('position', 'asc')
      ->get();
  }
}