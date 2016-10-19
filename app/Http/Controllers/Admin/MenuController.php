<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 14/09/2016
 * Time: 11:49
 */

namespace App\Http\Controllers\Admin;

use App\Repositories\MenuRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class MenuController
 * @package App\Http\Controllers\Admin
 */
class MenuController extends BaseAdminController {

  protected $menuRepo;

  public function __construct(MenuRepositoryInterface $menuRepository) {
    parent::__construct();
    $this->menuRepo = $menuRepository;
    $this->bodyClass = 'menu-controller';
    $this->routeLink = 'menus';
    $this->setPageTitle('Menu Management');
  }

  public function getIndex(Request $request) {
    return view('admin.menus.index');
  }
  
  public function postIndex() {
    
  }
  
  public function getEdit(Request $request, $id) {
    $this->data['object'] = new \stdClass();
    $oldInputs = old();
    if ($oldInputs && $id == 0) {
      $oldObject = new \stdClass();
      foreach ($oldInputs as $key => $row) {
        $oldObject->$key = $row;
      }
      $this->data['object'] = $oldObject;
    }

//    $currentEditLanguage = Models\Language::getBy([
//      'id' => $language,
//      'status' => 1,
//    ]);
//    if (!$currentEditLanguage) {
//      $this->_setFlashMessage('This language it not supported', 'error');
//      $this->_showFlashMessages();
//      return redirect()->back();
//    }
    $this->data['currentEditLanguage'] = 1;

    $this->data['rawUrlChangeLanguage'] = asset($this->adminPath . '/' . $this->routeLink . '/edit/' . $id) . '/';

//    $menu = $object->find($id);
//    if (!$menu) {
//      $menu = new Menu();
//      $menuContent = null;
//    } else {
//      $menuContent = $objectContent->findByFieldsOrCreate([
//        'menu_id' => $menu->id,
//        'language_id' => $language,
//      ]);
//    }

//    $this->setPageTitle('Menu', $menu->title);
//
//    $this->data['object'] = $menu;
//
//    $this->data['pages'] = Models\Page::getBy([
//      'status' => 1,
//    ], [
//      'global_title' => 'ASC',
//    ], true);

    //$this->data['categories'] = $this->_getCategoriesSelectSrc($category, 'category', 0);
    //$this->data['productCategories'] = $this->_getCategoriesSelectSrc($productCategory, 'product-category', 0);

    //$this->data['nestableMenuSrc'] = $this->getNestableMenuSrc($menuContent, 0);

    return view('admin.menus.edit', $this->data);
  }

  private function getNestableMenuSrc($menu, $parent_id)
  {
    if (!$menu) {
      return '';
    }

    $menu_nodes = $this->getMenuNodes($menu->id, $parent_id);
    $html_src = view('admin._partials.menu._nestable-menu-src', [
      'menuNodes' => $menu_nodes,
    ])->render();
    return $html_src;
  }

  private function getMenuNodes($menu_content_id, $parent_id)
  {
    if (!$menu_content_id) {
      return [];
    }

    $menu_nodes = MenuNode::getBy([
      'menu_content_id' => $menu_content_id,
      'parent_id' => $parent_id,
    ], ['position' => 'ASC'], true);
    return $menu_nodes;
  }
  
}