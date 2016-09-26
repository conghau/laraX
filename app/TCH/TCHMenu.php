<?php
namespace TCH;

use App\Models\Menu;
use App\Models\MenuNode;
use App\Repositories\MenuRepositoryInterface;

/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 15/09/2016
 * Time: 14:00
 */
class TCHMenu {

    /**
     * Construct
     */
    public $localeObj, $languageCode;

    protected $menuRepo;

    public function __construct(MenuRepositoryInterface $menuRepo) {
        $this->menuRepo = $menuRepo;
    }

    public function generateMenu($slug = '', $parent_id = 0, $view = 'menu::partials.menu', $active = FALSE, $theme = FALSE, $options = []) {
        $menu = $this->menuRepo->getFirstBy('slug', $slug, [], ['id', 'slug']);
        if (!$menu) {
            return NULL;
        }

        $menu_nodes = $this->menuRepo->getMenuNodes($menu->id, $parent_id, [
            'id',
            'menu_content_id',
            'parent_id',
            'related_id',
            'icon_font',
            'css_class',
            'url',
            'title',
            'type'
        ]);

        $menu_nodes_child = $this->menuRepo->getMenuNodesChild($menu->id, $parent_id, [
            'id',
            'menu_content_id',
            'parent_id',
            'related_id',
            'icon_font',
            'css_class',
            'url',
            'title',
            'type'
        ]);
        $html = '';
        //$html = view('admin._shared._sidebar1', compact('menu_nodes', 'menu', 'option'))->render();
        return $menu_nodes;
    }

    public function generateSelect($type, $parent_id = FALSE, $status = FALSE, $view = 'menu::partials.select', $theme = FALSE, $options = []) {

    }

    public function hasChild($slug = '', $active = TRUE) {
        $menu = $this->menuRepo->getFirstBy('slug', $slug);
        if (!$menu) {
            return FALSE;
        }
        return TRUE;
    }

    public $args = array(
        'menuName' => '',
        'menuClass' => '',
        'container' => '',
        'containerClass' => '',
        'containerId' => '',
        'containerTag' => 'ul',
        'childTag' => 'li',
        'itemHasChildrenClass' => '',
        'subMenuClass' => 'sub-menu',
        'menuActive' => [
            'type' => 'custom-link',
            'related_id' => 0,
        ],
        'activeClass' => 'active',
        'isAdminMenu' => FALSE,
    );

    public function getNavMenu1() {
        $defaultArgs = array(
            'languageId' => 0,
            'menuName' => 'admin-menu',
            'menuClass' => 'my-menu',
            'container' => 'nav',
            'containerClass' => '',
            'containerId' => '',
            'containerTag' => 'ul',
            'childTag' => 'li',
            'itemHasChildrenClass' => 'menu-item-has-children',
            'subMenuClass' => 'sub-menu',
            'menuActive' => [
                'type' => 'custom-link',
                'related_id' => 0,
            ],
            'activeClass' => 'active',
            'isAdminMenu' => FALSE,
        );
        $defaultArgs = array_merge($defaultArgs, $this->args);

        $output = '';
        $menu = $this->menuRepo->getFirstBy('slug', $defaultArgs['menuName'], [], ['id', 'slug']);
        if (!$menu) {
            return NULL;
        }
        if ($defaultArgs['container'] != '') {
            $output .= '<' . $defaultArgs['container'] . ' class="' . $defaultArgs['containerClass'] . '" id="' . $defaultArgs['containerId'] . '">';
        }
        //<nav>
        $output .= '<' . $defaultArgs['containerTag'] . ' class="' . $defaultArgs['menuClass'] . '"' . (($defaultArgs['isAdminMenu']) ? ' data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200"' : '') . '>'; //<ul>
        $child_args = array(
            'menuContentId' => $menu->id,
            'parentId' => 0,
            'isAdminMenu' => FALSE,
            'containerTag' => $defaultArgs['containerTag'],
            'childTag' => $defaultArgs['childTag'],
            'itemHasChildrenClass' => $defaultArgs['itemHasChildrenClass'],
            'subMenuClass' => $defaultArgs['subMenuClass'],
            'containerTagAttr' => '',
            'menuActive' => $defaultArgs['menuActive'],
            'defaultActiveClass' => $defaultArgs['activeClass'],
            //default active class
        );
        if ($defaultArgs['isAdminMenu'] == TRUE) {
            $child_args['isAdminMenu'] = TRUE;
            $output .= '<li class="sidebar-toggler-wrapper">
										<div class="sidebar-toggler">
										</div>
									</li>';
        }
        $menuItems = $this->menuRepo->getMenuNodesToArray($child_args['menuContentId'], [
            'id',
            'menu_content_id',
            'parent_id',
            'related_id',
            'icon_font',
            'css_class',
            'url',
            'title',
            'type'
        ]);
        $output .= $this->getMenuItems1($child_args, $menuItems);
        // $output.= '<div class="clearfix"></div></'.$defaultArgs['containerTag'].'>'; //</ul>
        $output .= '</' . $defaultArgs['containerTag'] . '>'; //</ul>
        if ($defaultArgs['container'] != '') {
            $output .= '</' . $defaultArgs['container'] . '>';
        }
        //</nav>
        return $output;
    }

    public function getMenuItems1($item_args, $menuItems) {
        $output = '';
        if (!$menuItems) {
            return NULL;
        }
        (sizeof($menuItems) > 0 && $item_args['parentId'] != 0) ? $output .= '<' . $item_args['containerTag'] . ' class="' . $item_args['subMenuClass'] . '"' . $item_args['containerTagAttr'] . '>' : $output .= ''; // <ul> will be printed if current is not level 0
        foreach ($menuItems as $key => $row) {
            $output .= $this->getMenuItem($item_args, $row);
        }
        (sizeof($menuItems) > 0 && $item_args['parentId'] != 0) ? $output .= '</' . $item_args['containerTag'] . '>' : $output .= ''; // </ul>
        return $output;
    }

    public function getMenuItem($item_args, $items) {
        $output = '';
        $arrow = '';
        if (isset($items['child']) && count($items['child']) > 0) {
            $arrow = '<span class="arrow"></span>';
        }

        // Get menu active class
        $active_args = array(
            'menuActive' => $item_args['menuActive'],
            'item' => $items['value'],
            'defaultActiveClass' => $item_args['defaultActiveClass'],
            'isAdminMenu' => $item_args['isAdminMenu'],
        );
        $activeClass = '';//$this->getActiveItems1($active_args);
//            if ($this->checkChildItemIsActive1(array(
//                    'parent' => $row['value'],
//                    'menuActive' => $item_args['menuActive'],
//                    'defaultActiveClass' => $item_args['defaultActiveClass'],
//                    'isAdminMenu' => $item_args['isAdminMenu']
//                )) == TRUE
//            ) {
//                if (trim($activeClass) == '') {
//                    $activeClass = ' current-parent-item';
//                    if ($item_args['isAdminMenu'] == TRUE) {
//                        $activeClass .= ' active';
//                    }
//                }
//                $arrow = '<span class="arrow open"></span>';
//            }

        $menu_title = $this->getMenuItemTitle($items['value']);
        $menu_link = $this->getMenuItemLink($items['value'], $item_args['isAdminMenu']);
        $parent_class = $items['value']->css_class . ' ';
        if ($this->checkItemHasChildren1($items)) {
            $parent_class .= $item_args['itemHasChildrenClass'];
        }

        $child_args = array(
            'menuContentId' => $item_args['menuContentId'],
            'parentId' => $items['value']->id,
            'isAdminMenu' => $item_args['isAdminMenu'],
            'containerTag' => $item_args['containerTag'],
            'childTag' => $item_args['childTag'],
            'itemHasChildrenClass' => $item_args['itemHasChildrenClass'],
            'subMenuClass' => $item_args['subMenuClass'],
            'containerTagAttr' => '',
            'menuActive' => $item_args['menuActive'],
            'defaultActiveClass' => $item_args['defaultActiveClass'],
            //default active class
        );

        $menu_icon = $menu_title;
        $linkClass = '';
        if ($item_args['isAdminMenu'] == TRUE) {
            $linkClass = ' nav-link nav-toggle ';
            $activeClass .= ' nav-item ';
            $menu_icon = '<i class="' . $items['value']->icon_font . '"></i> <span class="title">' . $menu_title . '</span><span class="selected"></span>';
            if ($this->checkItemHasChildren1($items)) {
                $menu_icon .= $arrow;
            }
        } else {
            if ($items['value']->icon_font) {
                $menu_icon = '<i class="' . $items['value']->icon_font . '"></i>' . $menu_icon;
            }
            $menu_icon = '<span>' . $menu_icon . '</span>';
        }

        $output .= '<' . $item_args['childTag'] . ' class="' . $parent_class . ' ' . $activeClass . '">'; #<li>
        $output .= '<a class="' . $linkClass . '" href="' . $menu_link . '" title="' . $menu_title . '">' . $menu_icon . '</a>';
        if ($this->checkItemHasChildren1($items)) {
            $output .= $this->getMenuItems1($child_args, $items['child']);
        }

        $output .= '</' . $item_args['childTag'] . '>'; #</li>
        return $output;
    }

    public function getNavMenu() {
        $defaultArgs = array(
            'languageId' => 0,
            'menuName' => '',
            'menuClass' => 'my-menu',
            'container' => 'nav',
            'containerClass' => '',
            'containerId' => '',
            'containerTag' => 'ul',
            'childTag' => 'li',
            'itemHasChildrenClass' => 'menu-item-has-children',
            'subMenuClass' => 'sub-menu',
            'menuActive' => [
                'type' => 'custom-link',
                'related_id' => 0,
            ],
            'activeClass' => 'active',
            'isAdminMenu' => FALSE,
        );
        $defaultArgs = array_merge($defaultArgs, $this->args);

        $output = '';
        $menu = Menu::join('menu_contents', 'menus.id', '=', 'menu_contents.menu_id')//            ->join('languages', 'languages.id', '=', 'menu_contents.language_id')
        ->where('menus.slug', '=', ltrim($defaultArgs['menuName']))//            ->where('menu_contents.language_id', '=', $defaultArgs['languageId'])
        ->select('menus.*', 'menu_contents.id as menu_content_id')->first();
        // Menu exists
        if (!is_null($menu)) {
            if ($defaultArgs['container'] != '') {
                $output .= '<' . $defaultArgs['container'] . ' class="' . $defaultArgs['containerClass'] . '" id="' . $defaultArgs['containerId'] . '">';
            }
            //<nav>
            $output .= '<' . $defaultArgs['containerTag'] . ' class="' . $defaultArgs['menuClass'] . '"' . (($defaultArgs['isAdminMenu']) ? ' data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200"' : '') . '>'; //<ul>
            $child_args = array(
                'menuContentId' => $menu->menu_content_id,
                'parentId' => 0,
                'isAdminMenu' => FALSE,
                'containerTag' => $defaultArgs['containerTag'],
                'childTag' => $defaultArgs['childTag'],
                'itemHasChildrenClass' => $defaultArgs['itemHasChildrenClass'],
                'subMenuClass' => $defaultArgs['subMenuClass'],
                'containerTagAttr' => '',
                'menuActive' => $defaultArgs['menuActive'],
                'defaultActiveClass' => $defaultArgs['activeClass'],
                //default active class
            );
            if ($defaultArgs['isAdminMenu'] == TRUE) {
                $child_args['isAdminMenu'] = TRUE;
                $output .= '<li class="sidebar-toggler-wrapper">
										<div class="sidebar-toggler">
										</div>
									</li>';
            }
            $output .= $this->getMenuItems($child_args);
            // $output.= '<div class="clearfix"></div></'.$defaultArgs['containerTag'].'>'; //</ul>
            $output .= '</' . $defaultArgs['containerTag'] . '>'; //</ul>
            if ($defaultArgs['container'] != '') {
                $output .= '</' . $defaultArgs['container'] . '>';
            }
            //</nav>
        }
        return $output;
    }

    // Function get all menu items
    private function getMenuItems($item_args) {
        $output = '';
        $menuItems = MenuNode::where([
            'menu_content_id' => $item_args['menuContentId'],
            'parent_id' => $item_args['parentId'],
        ], ['position' => 'ASC'], TRUE)->get();
        if ($menuItems) {
            (sizeof($menuItems) > 0 && $item_args['parentId'] != 0) ? $output .= '<' . $item_args['containerTag'] . ' class="' . $item_args['subMenuClass'] . '"' . $item_args['containerTagAttr'] . '>' : $output .= ''; // <ul> will be printed if current is not level 0
            foreach ($menuItems as $key => $row) {
                $arrow = '';
                if (count($row->child) > 0) {
                    $arrow = '<span class="arrow"></span>';
                }

                // Get menu active class
                $active_args = array(
                    'menuActive' => $item_args['menuActive'],
                    'item' => $row,
                    'defaultActiveClass' => $item_args['defaultActiveClass'],
                    'isAdminMenu' => $item_args['isAdminMenu'],
                );
                $activeClass = $this->getActiveItems($active_args);
                if ($this->checkChildItemIsActive(array(
                        'parent' => $row,
                        'menuActive' => $item_args['menuActive'],
                        'defaultActiveClass' => $item_args['defaultActiveClass'],
                        'isAdminMenu' => $item_args['isAdminMenu']
                    )) == TRUE
                ) {
                    if (trim($activeClass) == '') {
                        $activeClass = ' current-parent-item';
                        if ($item_args['isAdminMenu'] == TRUE) {
                            $activeClass .= ' active';
                        }
                    }
                    $arrow = '<span class="arrow open"></span>';
                }

                $menu_title = $this->getMenuItemTitle($row);
                $menu_link = $this->getMenuItemLink($row, $item_args['isAdminMenu']);
                $parent_class = $row->css_class . ' ';
                if ($this->checkItemHasChildren($row)) {
                    $parent_class .= $item_args['itemHasChildrenClass'];
                }

                $child_args = array(
                    'menuContentId' => $item_args['menuContentId'],
                    'parentId' => $row->id,
                    'isAdminMenu' => $item_args['isAdminMenu'],
                    'containerTag' => $item_args['containerTag'],
                    'childTag' => $item_args['childTag'],
                    'itemHasChildrenClass' => $item_args['itemHasChildrenClass'],
                    'subMenuClass' => $item_args['subMenuClass'],
                    'containerTagAttr' => '',
                    'menuActive' => $item_args['menuActive'],
                    'defaultActiveClass' => $item_args['defaultActiveClass'],
                    //default active class
                );

                $menu_icon = $menu_title;
                $linkClass = '';
                if ($item_args['isAdminMenu'] == TRUE) {
                    $linkClass = ' nav-link nav-toggle ';
                    $activeClass .= ' nav-item ';
                    $menu_icon = '<i class="' . $row->icon_font . '"></i> <span class="title">' . $menu_title . '</span><span class="selected"></span>';
                    if ($this->checkItemHasChildren($row)) {
                        $menu_icon .= $arrow;
                    }
                } else {
                    if ($row->icon_font) {
                        $menu_icon = '<i class="' . $row->icon_font . '"></i>' . $menu_icon;
                    }
                    $menu_icon = '<span>' . $menu_icon . '</span>';
                }

                $output .= '<' . $item_args['childTag'] . ' class="' . $parent_class . ' ' . $activeClass . '">'; #<li>
                $output .= '<a class="' . $linkClass . '" href="' . $menu_link . '" title="' . $menu_title . '">' . $menu_icon . '</a>';
                $output .= $this->getMenuItems($child_args, $menuItems);
                $output .= '</' . $item_args['childTag'] . '>'; #</li>
            }
            (sizeof($menuItems) > 0 && $item_args['parentId'] != 0) ? $output .= '</' . $item_args['containerTag'] . '>' : $output .= ''; // </ul>
        }
        return $output;
    }

    // Menu active
    private function getActiveItems($args) {
        $temp = $args['menuActive'];
        $result = '';
        if ($args['item']->type == $args['menuActive']['type']) {
            if (is_array($args['menuActive']['related_id'])) {
                switch ($args['menuActive']['type']) {
                    case 'category': {
                        if (in_array($args['item']->related_id, $args['menuActive']['related_id'])) {
                            $result = $args['defaultActiveClass'];
                        }
                    }
                        break;
                    case 'product-category': {
                        if (in_array($args['item']->related_id, $args['menuActive']['related_id'])) {
                            $result = $args['defaultActiveClass'];
                        }
                    }
                        break;
                    default: {
                        if (in_array($args['item']->related_id, $args['menuActive']['related_id'])) {
                            $result = $args['defaultActiveClass'];
                        }
                    }
                        break;
                }
            } else {
                switch ($args['menuActive']['type']) {
                    case 'category': {
                        if ($args['menuActive']['related_id'] == $args['item']->related_id) {
                            $result = $args['defaultActiveClass'];
                        }
                    }
                        break;
                    case 'product-category': {
                        if ($args['menuActive']['related_id'] == $args['item']->related_id) {
                            $result = $args['defaultActiveClass'];
                        }
                    }
                        break;
                    case 'custom-link': {
                        $currentUrl = \Request::url();
                        if ($args['isAdminMenu']) {
                            if ($args['menuActive']['related_id'] == $args['item']->url) {
                                $result = $args['defaultActiveClass'];
                            }
                        } else {
                            if (asset($args['item']->url) == asset($currentUrl) || asset($args['item']->url) == asset($currentUrl . '/')) {
                                $result = $args['defaultActiveClass'];
                            }
                        }
                    }
                        break;
                    default: {
                        if ($args['menuActive']['related_id'] == $args['item']->related_id) {
                            $result = $args['defaultActiveClass'];
                        }
                    }
                        break;
                }
            }
        }
        return $result;
    }

    private function getActiveItems1($args) {
        $temp = $args['menuActive'];
        $result = '';
        if ($args['item']->type == $args['menuActive']['type']) {
            if (is_array($args['menuActive']['related_id'])) {
                switch ($args['menuActive']['type']) {
                    case 'category': {
                        if (in_array($args['item']->related_id, $args['menuActive']['related_id'])) {
                            $result = $args['defaultActiveClass'];
                        }
                    }
                        break;
                    case 'product-category': {
                        if (in_array($args['item']->related_id, $args['menuActive']['related_id'])) {
                            $result = $args['defaultActiveClass'];
                        }
                    }
                        break;
                    default: {
                        if (in_array($args['item']->related_id, $args['menuActive']['related_id'])) {
                            $result = $args['defaultActiveClass'];
                        }
                    }
                        break;
                }
            } else {
                switch ($args['menuActive']['type']) {
                    case 'category': {
                        if ($args['menuActive']['related_id'] == $args['item']->related_id) {
                            $result = $args['defaultActiveClass'];
                        }
                    }
                        break;
                    case 'product-category': {
                        if ($args['menuActive']['related_id'] == $args['item']->related_id) {
                            $result = $args['defaultActiveClass'];
                        }
                    }
                        break;
                    case 'custom-link': {
                        $currentUrl = \Request::url();
                        if ($args['isAdminMenu']) {
                            if ($args['menuActive']['related_id'] == $args['item']->url) {
                                $result = $args['defaultActiveClass'];
                            }
                        } else {
                            if (asset($args['item']->url) == asset($currentUrl) || asset($args['item']->url) == asset($currentUrl . '/')) {
                                $result = $args['defaultActiveClass'];
                            }
                        }
                    }
                        break;
                    default: {
                        if ($args['menuActive']['related_id'] == $args['item']->related_id) {
                            $result = $args['defaultActiveClass'];
                        }
                    }
                        break;
                }
            }
        }
        return $result;
    }

    // Check children active
    private function checkChildItemIsActive($args) {
        return $this->_recursiveIsChildItemActive($args);
    }

    private function checkChildItemIsActive1($args) {
        return $this->_recursiveIsChildItemActive1($args);
    }

    private function _recursiveIsChildItemActive($args) {
        if ($this->getActiveItems(array(
                'menuActive' => $args['menuActive'],
                'item' => $args['parent'],
                'defaultActiveClass' => $args['defaultActiveClass'],
                'isAdminMenu' => $args['isAdminMenu']
            )) != ''
        ) {
            return TRUE;
        }
        $result = FALSE;
        $menuNodes = MenuNode::where([
            'parent_id' => $args['parent']->id,
        ], ['position' => 'ASC'], TRUE);
        foreach ($menuNodes as $key => $row) {
            $childArgs = $args;
            $childArgs['parent'] = $row;
            $result = $this->_recursiveIsChildItemActive($childArgs);
            if ($result) {
                return TRUE;
            }

        }
        return $result;
    }

    private function _recursiveIsChildItemActive1($args) {
        if ($this->getActiveItems(array(
                'menuActive' => $args['menuActive'],
                'item' => $args['parent'],
                'defaultActiveClass' => $args['defaultActiveClass'],
                'isAdminMenu' => $args['isAdminMenu']
            )) != ''
        ) {
            return TRUE;
        }
        $result = FALSE;
        $menuNodes = MenuNode::where([
            'parent_id' => $args['parent']->id,
        ], ['position' => 'ASC'], TRUE);
        foreach ($menuNodes as $key => $row) {
            $childArgs = $args;
            $childArgs['parent'] = $row;
            $result = $this->_recursiveIsChildItemActive($childArgs);
            if ($result) {
                return TRUE;
            }

        }
        return $result;
    }

    // Get item title
    private function getMenuItemTitle($item) {
        $data_title = '';
        if (is_null($item) || empty($item)) {
            return $data_title = '';
        }

        switch ($item->type) {
            case 'page': {
                $title = $item->title;
                if (!$title) {
                    $page = Models\Page::getBy([
                        'id' => $item->related_id,
                    ]);
                    if ($page) {
                        $pageContent = $page->pageContent()
                            ->join('languages', 'languages.id', '=', 'page_contents.language_id')
                            ->where('languages.id', '=', $this->localeObj->id)
                            ->select('page_contents.title')
                            ->first();
                        if ($pageContent) {
                            $title = ((trim($pageContent->title) != '') ? trim($pageContent->title) : trim($page->global_title));
                        }
                    } else {
                        $title = '';
                    }
                }
                $data_title = $title;
            }
                break;
            case 'category': {
                $title = $item->title;
                if (!$title) {
                    $cat = Models\Category::getWithContent([
                        'categories.id' => [
                            'compare' => '=',
                            'value' => $item->related_id,
                        ],
                        'category_contents.language_id' => [
                            'compare' => '=',
                            'value' => $this->localeObj->id,
                        ],
                    ]);
                    if ($cat) {
                        $title = ((trim($cat->title) != '') ? trim($cat->title) : trim($cat->global_title));
                    } else {
                        $title = '';
                    }
                }
                $data_title = $title;
            }
                break;
            case 'product-category': {
                $title = $item->title;
                if (!$title) {
                    $cat = Models\ProductCategory::getWithContent([
                        'product_categories.id' => [
                            'compare' => '=',
                            'value' => $item->related_id,
                        ],
                        'product_category_contents.language_id' => [
                            'compare' => '=',
                            'value' => $this->localeObj->id,
                        ],
                    ]);
                    if ($cat) {
                        $title = ((trim($cat->title) != '') ? trim($cat->title) : trim($cat->global_title));
                    } else {
                        $title = '';
                    }
                }
                $data_title = $title;
            }
                break;
            case 'custom-link': {
                $data_title = $item->title;
                if (!$data_title) {
                    $data_title = '';
                }

            }
                break;
            default: {
                $data_title = $item->title;
                if (!$data_title) {
                    $data_title = '';
                }

            }
                break;
        }
        $data_title = htmlentities($data_title);
        return $data_title;
    }

    // Get item links
    private function getMenuItemLink($item, $isAdminMenu = FALSE) {
        $result = '';
        if (is_null($item) || empty($item)) {
            return $result = '';
        }
        switch ($item->type) {
            case 'page': {
                $slug = '';
                $page = Models\Page::getWithContent([
                    'pages.id' => [
                        'compare' => '=',
                        'value' => $item->related_id,
                    ],
                    'page_contents.language_id' => [
                        'compare' => '=',
                        'value' => $this->localeObj->id,
                    ],
                ]);
                if ($page) {
                    $slug = (trim($page->slug) != '') ? trim($page->slug) : '';
                }

                $result = _getPageLink($slug, $this->languageCode);
            }
                break;
            case 'category': {
                $result = _getCategoryLinkWithParentSlugs($item->related_id, $this->languageCode);
            }
                break;
            case 'product-category': {
                $result = _getProductCategoryLinkWithParentSlugs($item->related_id, $this->languageCode);
            }
                break;
            case 'custom-link': {
                if ($isAdminMenu == TRUE) {
                    $result = asset(\Config::get('app.admin_path') . '/' . $item->url);
                } else {
                    $result = $item->url;
                }
            }
                break;
            default: {
                if ($isAdminMenu == TRUE) {
                    $result = asset(\Config::get('app.admin_path') . '/' . $item->url);
                } else {
                    $result = $item->url;
                }
            }
                break;
        }
        return $result;
    }

    // Check menu has children or not
    private function checkItemHasChildren($item) {
        if (count($item->child) > 0) {
            return TRUE;
        }

        return FALSE;
    }

    // Check menu has children or not
    private function checkItemHasChildren1($item) {
        if (isset($item['child']) && count($item['child']) > 0) {
            return TRUE;
        }

        return FALSE;
    }
}