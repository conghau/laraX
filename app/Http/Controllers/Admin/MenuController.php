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
use TCH\LaraXConfig;

/**
 * Class MenuController
 * @package App\Http\Controllers\Admin
 */
class MenuController extends BaseAdminController {

    private $menuRepo;

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

    public function getEdit(Request $request, $id = 0) {
        $this->setFlashMessages(LaraXConfig::MESSAGE_TYPE_INFO, 'Go to edit menu');
        $this->setFlashMessages(LaraXConfig::MESSAGE_TYPE_ERROR, 'Go to edit menu1');
        $this->showFlashMessages();
        $this->data['object'] = new \stdClass();
        $oldInputs = old();
        if ($oldInputs && $id == 0) {
            $oldObject = new \stdClass();
            foreach ($oldInputs as $key => $row) {
                $oldObject->$key = $row;
            }
            $this->data['object'] = $oldObject;
        }
        $menu = new \stdClass();
        if (0 !== $id) {
            $menu = $this->menuRepo->findById($id);
            $this->data['object'] = $menu;
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

        $this->data['rawUrlChangeLanguage'] = asset($this->adminPath . '/' . $this->routeLink . '/edit/' . $id);

        $menuContent = NULL;
//    $menu = $object->find($id);
        if (!laraX_isNullOrEmpty($menu)) {
            //$menuContent = $menu->menuContent;
            $menuContent = $this->menuRepo->getMenuContentModel()->firstOrNew([
                'menu_id' => $menu->id,
                //'language_id' => 1,
            ]);
        }


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

    public function postEdit(Request $request, $id) {
        $id = intval($id);
        $menu = $this->menuRepo->firstOrNew(['id' => $id]);
        $data = $request->only(['name', 'slug']);
        $data['id'] = $id;
        $data['slug'] = (isset($data['slug'])) ? str_slug($data['slug']) : str_slug($data['name']);

        //$menuContent = $menu->menuContent;
        $menuContent = $this->menuRepo->getMenuContentModel()->firstOrNew([
            'menu_id' => $menu->id,
            //'language_id' => 1,
        ]);
        if (!$menuContent) {
//            $resultEditContent = $objectContent->fastEdit([
//                'menu_id' => $menu->id,
//                'language_id' => $language,
//            ], true, true);
//            if ($resultEditContent['error']) {
//                $this->_setFlashMessage($resultEditContent['message'], 'error');
//                $this->_showFlashMessages();
//                return redirect()->back();
//            }
//            $menuContent = $resultEditContent['object'];
        }

        $menuNodesJson = json_decode($request->get('menu_nodes', NULL));

        /*Deleted nodes*/
        $deletedNodes = explode(' ', ltrim($request->get('deleted_nodes', '')));
        // $this->menuRepo->getMenuNodes()->whereIn('id', $deletedNodes)->delete();
        $message_err = '';
        if($this->menuRepo->saveMenuNodes($menuNodesJson, $menuContent->id, 0, $message_err)) {
            $this->setFlashMessages(LaraXConfig::MESSAGE_TYPE_SUCCESS, 'Save success');
        } else {
            $this->setFlashMessages(LaraXConfig::MESSAGE_TYPE_ERROR, 'Save fail');
        }

        $this->showFlashMessages();

        if (!$id || $id == 0) {
            return redirect()->to(asset($this->adminPath . '/' . $this->routeLink . '/edit/' . $menu->id));
        }
        $request->session()->flash('message', $message_err);
        return redirect()->to(asset($this->adminPath . '/' . $this->routeLink . '/edit/' . $menu->id));
        return redirect()->back();

    }

    private function getNestableMenuSrc($menu, $parent_id) {
        if (!$menu) {
            return '';
        }
        $menu_nodes = $this->menuRepo->getMenuNodesToArray($menu->id);
        //$menu_nodes = $this->menuRepo->getMenuNodes($menu->id, $parent_id);
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