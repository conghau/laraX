<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 20/10/2016
 * Time: 11:14
 */

namespace App\Http\Controllers\Admin;


use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Http\Request;


/**
 * Class CategoryController
 * @package App\Http\Controllers\Admin
 */
class CategoryController extends BaseAdminController {

    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository) {
        parent::__construct();
        $this->categoryRepository = $categoryRepository;
    }

    public function getIndex() {
        return view('admin.categories.index');
    }

    public function postIndex(Request $request) {
        $all = $request->all();

        //get pagination
        $offset = $request->get('start', 0);
        $limit = $request->get('length', 10);
        $paged = ceil(($offset + $limit) / $limit);

        $target_like_filters = [
            'name',
            'template',
        ];

        $target_eq_filters = [
            'status'
        ];

        $target_orderBy = [
            1 => 'id',
            2 => 'name',
            4 => 'status',
            6 => 'created_at',
        ];
        $conditions = [];

        //build where condition
        foreach ($target_like_filters as $like_filter) {
            if ($fv = laraX_get_value($all, $like_filter, FALSE)) {
                $conditions[] = [$like_filter, 'LIKE', "%$fv%"];
            }
        };
        foreach ($target_eq_filters as $eq_filter) {
            if ($fv = laraX_get_value($all, $eq_filter, FALSE)) {
                $conditions[$eq_filter] = $fv;
            }
        };

        $order_by = [];
        //build order by
        foreach ($items = laraX_get_value($all, 'order', []) as $item) {
            $order_by[array_key_exists($item['column'], $target_orderBy) ? $target_orderBy[$item['column']] : 'created_at'] = $item['dir'];
        };

        //get result
        $result = $this->categoryRepository->findWhere($conditions, $paged, $limit, $order_by);

        //prepare output
        $records = [];
        $records['data'] = [];
        foreach ($items = $result->items as $item) {
            $records['data'][] = array(
                '<input type="checkbox" name="id[]" value="' . $item->id . '">',
                $item->id,
                $item->name,
                $item->template,
                '<span class="label label-success label-sm label-{{$item->status}}">' . $item->status . '</span>',
                $item->position,
                $item->created_at,
                'fast edit',
                laraX_build_button_confirmation(laraX_build_url($this->routeLink . '/active/' . $item->id), 'Active User', 'blue', 'fa fa-check')
                . laraX_build_button_confirmation(laraX_build_url($this->routeLink . '/dataable/' . $item->id), 'Delete User', 'red-sunglo', 'fa fa-times')
                . laraX_build_button(laraX_build_url($this->routeLink . '/edit/' . $item->id), 'edit', 'green', 'icon-pencil'),
            );
        }
        $records["sEcho"] = 'echo';
        $records["iTotalRecords"] = $result->totalItems;
        $records["iTotalDisplayRecords"] = $result->totalItems;
        return response()->json($records);

    }
    
    public function getEdit(Request $request, $id = 0) {
        $this->data['object'] = new \stdClass();
        if(!$id) {
            $this->setPageTitle('Create category');
            $oldInputs = old();
            if ($oldInputs) {
                $oldObject = new \stdClass();
                foreach ($oldInputs as $key => $row) {
                    $oldObject->$key = $row;
                }
                $this->data['object'] = $oldObject;
            }
        }
        $currentEditLanguage = 1;
//        $currentEditLanguage = Models\Language::getBy([
//            'id' => $language,
//            'status' => 1,
//        ]);
        if (!$currentEditLanguage) {
            $this->setFlashMessage('This language it not supported', 'error');
            $this->showFlashMessages();
            return redirect()->back();
        }
        $this->data['currentEditLanguage'] = $currentEditLanguage;

        $this->data['rawUrlChangeLanguage'] = asset($this->adminPath . '/' . $this->routeLink . '/edit/' . $id);

//        if (!$id) {
//            $item = $object->find($id);
//            /*No page with this id*/
//            if (!$item) {
//                $this->_setFlashMessage('Item not exists.', 'error');
//                $this->_showFlashMessages();
//                return redirect()->back();
//            }
//
//            $item = $object->getById($id, $language, [
//                'status' => null,
//                'global_status' => null,
//            ]);
//            /*Create new if not exists*/
//            if (!$item) {
//                $item = new CategoryContent();
//                $item->language_id = $language;
//                $item->created_by = $this->loggedInAdminUser->id;
//                $item->category_id = $id;
//                $item->save();
//                $item = $object->getById($id, $language, [
//                    'status' => null,
//                    'global_status' => null,
//                ]);
//            }
//            $this->data['object'] = $item;
//            $this->_setPageTitle('Edit category', $item->global_title);
//
//            $args = array(
//                'user_type' => $this->loggedInAdminUser->adminUserRole->id,
//                'category_id' => $id,
//                'category_template' => $item->page_template,
//                'user' => $this->loggedInAdminUser->id,
//                'model_name' => 'Category',
//            );
//            $customFieldBoxes = new Acme\CmsCustomField();
//            $customFieldBoxes = $customFieldBoxes->getCustomFieldsBoxes($item->content_id, $args, 'category');
//            $this->data['customFieldBoxes'] = $customFieldBoxes;
//
//            $categories = $this->_recursiveGetCategoriesSelectSrc($object, 0, 'global_title', 'asc', 0, $item->parent_id, [$id]);
//        } else {
//            $categories = $this->_recursiveGetCategoriesSelectSrc($object, 0, 'global_title', 'asc', 0, 0, []);
//        }

        $this->data['categoriesHtmlSrc'] = '';//$categories;

        return view('admin.categories.edit', $this->data);
    }
    
    public function postEdit(Request $request) {
        
    }

}