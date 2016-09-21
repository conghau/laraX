<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 9/13/2016
 * Time: 4:37 AM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\MenuRepositoryInterface;
use TCH\TCHMenu;

class BaseAdminController extends Controller {

    protected $menuRepository;

    public function __construct() {
//        $this->menuRepository = $menuRepository;
        $this->setMenuRepository(app(MenuRepositoryInterface::class));
//        $this->setMenuRepository(app(MenuRepositoryInterface::class));
//        $this->_loadAdminMenu();
    }

    protected function setPageTitle($title, $subTitle = '') {
        view()->share([
            'pageTitle' => $title,
            'subPageTitle' => $subTitle,
        ]);
    }

    protected function setMenuRepository(MenuRepositoryInterface $_menuRepository) {
        return $this->menuRepository = $_menuRepository;
    }

    protected function _loadAdminMenu($menuActive = '') {
        $menu = new TCHMenu();
//        $menu->localeObj = $this->defaultLanguage;
//        $menu->languageCode = $this->defaultLanguage->language_code;
        $menu->args = array(
//            'languageId' => $this->_getSetting('dashboard_language', $this->defaultLanguageId),
            'menuName' => 'admin-menu',
            'menuClass' => 'page-sidebar-menu page-header-fixed',
            'container' => 'div',
            'containerClass' => 'page-sidebar navbar-collapse collapse',
            'containerId' => '',
            'containerTag' => 'ul',
            'childTag' => 'li',
            'itemHasChildrenClass' => 'menu-item-has-children',
            'subMenuClass' => 'sub-menu',
            'menuActive' => [
                'type' => 'custom-link',
                'related_id' => $menuActive,
            ],
            'activeClass' => 'active',
            'isAdminMenu' => true,
        );
//        $menu_parent = $this->menuRepository->has('menuContent')->toArray();
        $t = $this->menuRepository->getItems();
        var_dump($t);
        $data = $menu->getNavMenu();
        view()->share('CMSMenuHtml', $data);
    }
}