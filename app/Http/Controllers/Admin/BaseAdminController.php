<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 9/13/2016
 * Time: 4:37 AM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class BaseAdminController extends Controller {

    public function __construct() {
    }

    protected function setPageTitle($title, $subTitle = '')
    {
        view()->share([
            'pageTitle' => $title,
            'subPageTitle' => $subTitle,
        ]);
    }
}