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
use Illuminate\Support\Facades\Config;
use TCH\TCHMenu;

class BaseAdminController extends Controller {

  protected $menuRepository;

  protected $adminPath;
  protected $defaultLanguageId;
  
  protected $data = [];

  public function __construct() {
    $this->adminPath = Config::get('app.admin_path');
    //$this->setMenuRepository(app(MenuRepositoryInterface::class));
    $this->_loadAdminMenu();
    
    view()->share([
      'adminPath' => $this->adminPath,
      'defaultLanguageId' => 1
    ]);
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
    $menu = app(TCHMenu::class);
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
      'isAdminMenu' => TRUE,
    );
    $data = $menu->getNavMenu1($menu->args);
    view()->share('CMSMenuHtml', $data);
  }
}