<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 10/8/2016
 * Time: 2:27 PM
 */

namespace App\Http\Controllers\Admin;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers\Admin
 */
class DashboardController extends BaseAdminController {
    public function __construct() {
        parent::__construct('Dashboard');
        $this->setPageTitle('Dashboard', 'dashboard & statistics');
        $this->setBodyClass($this->bodyClass);

    }

    public function getIndex() {
        echo 'Welcome Admin';
    }
}