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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use TCH\LaraXMenu;
use App\Http\Foundation;
use Carbon;

/**
 * Class BaseAdminController
 *
 * @package App\Http\Controllers\Admin
 */
class BaseAdminController extends Controller {

    use Foundation\FlashMessage;

    protected $menuRepository;
    protected $adminPath;
    protected $routeLink;
    protected $defaultLanguageId;
    protected $bodyClass;
    protected $currentMenuActive;
    protected $data = [];

    public function __construct($currentMenuActive = '') {
        $this->middleware('auth.admin',  ['except' => ['getLogin', 'postLogin']]);

        $this->adminPath = Config::get('app.admin_path');
        //$this->setMenuRepository(app(MenuRepositoryInterface::class));
        $this->currentMenuActive = $currentMenuActive;
        $this->loadAdminMenu($currentMenuActive);

        view()->share([
            'adminPath' => $this->adminPath,
            'defaultLanguageId' => 1
        ]);
    }

    protected function initVariable() {
        $this->adminPath = Config::get('app.admin_path');
        $this->defaultLanguageId = 1;
        $this->bodyClass = '';
        $this->currentMenuActive = 'Dashboard';
    }


    /**
     * Set current menu active
     *
     * @param string $menuClassActive
     *
     * @return string
     */
    protected function setCurrentMenuActive($menuClassActive = '') {
        return $this->currentMenuActive = $menuClassActive;
    }

    /**
     * Set custom body class
     *
     * @param string $class
     *
     * @return string
     */
    protected function setBodyClass($class = '') {
        return $this->bodyClass = $class;
    }

    /**
     * Set page title
     *
     * @param $title
     * @param string $subTitle
     */
    protected function setPageTitle($title, $subTitle = '') {
        view()->share([
            'pageTitle' => $title,
            'subPageTitle' => $subTitle,
        ]);
    }

    /**
     * Set menu Repository
     *
     * @param MenuRepositoryInterface $_menuRepository
     *
     * @return MenuRepositoryInterface
     */
    protected function setMenuRepository(MenuRepositoryInterface $_menuRepository) {
        return $this->menuRepository = $_menuRepository;
    }

    /**
     * Load admin menu
     *
     * @param string $menuActive
     */
    protected function loadAdminMenu($menuActive = '') {
        $menu = app(LaraXMenu::class);
        $menu->args = array(
            'languageId' => 1,
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

        $data = '';
        $expiresAt = Carbon::now()->addMinutes(30);
        if (Cache::has('cache_admin_menu')) {
            $data = Cache::get('cache_admin_menu');;
        } else {
            $data = $menu->getNavMenu1($menu->args);
            Cache::put('cache_admin_menu', $data, $expiresAt);
        }

        view()->share('CMSMenuHtml', $data);
    }
}