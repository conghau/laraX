<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 14/09/2016
 * Time: 10:15
 */

namespace App\Repositories\Impl;

use App\Models\Menu;
use App\Models\MenuContent;
use App\Models\MenuNode;
use App\Repositories\Base\BaseRepositoryImpl;
use App\Repositories\MenuRepositoryInterface;
use App\Helpers\LaraXHelper;
use Illuminate\Support\Facades\Session;
use TCH\LaraXConfig;

/**
 * Class MenuRepository
 *
 * @package App\Repositories
 */
class MenuRepository extends BaseRepositoryImpl implements MenuRepositoryInterface {

    protected $menuContentModel;
    protected $menuNoteModel;

    public function __construct(Menu $model, MenuContent $menuContent, MenuNode $menuNode) {
        $this->model = $model;
        $this->menuContentModel = $menuContent;
        $this->menuNoteModel = $menuNode;
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
        $menu_parent = $this->getMenuNodes($menu_content_id, 0, $columns)
            ->toArray();
        if (is_null($menu_parent)) {
            return NULL;
        }

        $menu_after = array();
        foreach ($menu_parent as $item) {
            $menu_after[$item['id']] = array('value' => (object)$item);
        }

        $menu_child = $this->getMenuNodesChild($menu_content_id, 0, $columns)
            ->toArray();
        if (is_null($menu_child)) {
            return $menu_after;
        }

        $dept = 1;
        LaraXHelper::buildMenus($menu_after, $menu_child, $dept);
        return $menu_after;
    }

    public function getMenuContents($menu_slug, $columns = array('*')) {
        Menu::join('menu_contents', 'menus.id', '=', 'menu_contents.menu_id')//            ->join('languages', 'languages.id', '=', 'menu_contents.language_id')
        ->where('menus.slug', '=', $menu_slug)//            ->where('menu_contents.language_id', '=', $defaultArgs['languageId'])
        ->select('menus.*', 'menu_contents.id as menu_content_id')->first();
    }

    public function getMenuContentModel() {
        return $this->menuContentModel;
    }

    public function getMenuNodeModel() {
        return $this->menuNoteModel;
    }

    public function saveMenuNode(array $item, $menu_content_id, $parent_id, &$message_err = '', $throw_ex = FALSE) {
        try {
            $target_string_field = [
                'title',
                'url',
                'css_class',
                'position',
                'icon_font',
                'type'
            ];
            $data = [
                'id' => laraX_get_value($item, 'id', 0),
                'menu_content_id' => $menu_content_id,
                'parent_id' => $parent_id,
            ];

            foreach ($target_string_field as $field) {
                $data[$field] = laraX_get_value($item, $field);
            }

            switch (laraX_get_value($item, 'type')) {
                case 'custom-link':
                    $data['related_id'] = 0;
                    break;
                default:
                    $data['related_id'] = laraX_get_value($item, 'relatedid', 0);
                    break;
            }

            return $this->createOrUpdate($data, $this->menuNoteModel, $message_err, $throw_ex);
        } catch (\Exception $e) {
            if ($throw_ex) {
                throw $e;
            }
            return FALSE;
        }
    }

    public function saveMenuNodes(array $items, $menu_content_id, $parent_id, &$message_err = '', $throw_ex = FALSE) {
        try {
            \DB::beginTransaction();
            $result = $this->recursiveSaveMenuNodes($items, $menu_content_id, $parent_id, $message_err, $throw_ex);
            if (!$result) {
                throw new \Exception($message_err);
            }
            \DB::commit();
            return TRUE;
        } catch (\Exception $e) {
            \DB::rollback();
            if ($throw_ex) {
                throw $e;
            }
            return FALSE;
        }
    }

    private function recursiveSaveMenuNodes(array $items, $menu_content_id, $parent_id, &$message_err = '', $throw_ex = FALSE) {
        try {
            foreach ($items as $item) {
                if (is_object($item)) {
                    $item = (array)$item;
                }
                $parent = $this->saveMenuNode($item, $menu_content_id, $parent_id, $message_err, $throw_ex);
                if (0 == $parent) {
                    throw new \Exception($message_err);
                }
                if (isset($item['children']) && !laraX_isNullOrEmpty($item['children'])) {
                    $this->recursiveSaveMenuNodes($item['children'], $menu_content_id, $parent, $message_err, $throw_ex);
                }
            }
            return TRUE;
        } catch (\Exception $e) {
            $message_err = $e->getMessage();
            if ($throw_ex) {
                throw $e;
            }
            return FALSE;
        }
    }
}