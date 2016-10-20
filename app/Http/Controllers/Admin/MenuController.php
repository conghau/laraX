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

    public function postIndex(Request $request) {
        $all = $request->all();

        //get pagination
        $offset = $request->get('start', 0);
        $limit = $request->get('length', 10);
        $paged = ceil(($offset + $limit) / $limit);

        $target_like_filters = [
            'name',
            'slug',
        ];

        $target_eq_filters = [
            'status'
        ];

        $target_orderBy = [
            1 => 'id',
            2 => 'name',
            3 => 'slug',
            4 => 'created_at',
        ];

        //build where condition
        $conditions = $this->buildCondition($all, $target_eq_filters, $target_like_filters);
        //build order by
        $order_by = $this->buildOrderBy($all, $target_orderBy);

        //get result
        $result = $this->menuRepo->findWhere($conditions, $paged, $limit, $order_by);

        //prepare output
        $records = [];
        $records['data'] = [];
        foreach ($items = $result->items as $item) {
            $records['data'][] = array(
                '<input type="checkbox" name="id[]" value="' . $item->id . '">',
                $item->id,
                $item->name,
                $item->slug,
                $item->created_at,
                'fast edit',
                laraX_build_button_confirmation(laraX_build_url($this->routeLink . '/active/' . $item->id), 'Active User', 'blue', 'fa fa-check') . laraX_build_button_confirmation(laraX_build_url($this->routeLink . '/dataable/' . $item->id), 'Delete User', 'red-sunglo', 'fa fa-times') . laraX_build_button(laraX_build_url($this->routeLink . '/edit/' . $item->id), 'edit', 'green', 'icon-pencil'),
            );
        }
        $records["sEcho"] = 'echo';
        $records["iTotalRecords"] = $result->totalItems;
        $records["iTotalDisplayRecords"] = $result->totalItems;
        return response()->json($records);
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

        $menuContent = NULL;
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

        $this->data['nestableMenuSrc'] = $this->getNestableMenuSrc($menuContent, 0);

        return view('admin.menus.edit', $this->data);
    }

    private function getNestableMenuSrc($menu, $parent_id) {
        if (!$menu) {
            return '';
        }

        $menu_nodes = $this->menuRepo->getMenuNodes($menu->id, $parent_id);
        $html_src = view('admin._partials.menu._nestable-menu-src', [
            'menuNodes' => $menu_nodes,
        ])->render();
        return $html_src;
    }

    private function getMenuNodes($menu_content_id, $parent_id) {
        if (!$menu_content_id) {
            return [];
        }

        $menu_nodes = MenuNode::getBy([
            'menu_content_id' => $menu_content_id,
            'parent_id' => $parent_id,
        ], ['position' => 'ASC'], TRUE);
        return $menu_nodes;
    }

}