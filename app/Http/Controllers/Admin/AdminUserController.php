<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 10/9/2016
 * Time: 9:09 PM
 */

namespace App\Http\Controllers\Admin;

/**
 * Class AdminUserController
 *
 * @package App\Http\Controllers\Admin
 */
class AdminUserController extends BaseAdminController {
    public function __construct() {
        parent::__construct('users');
    }

    public function getIndex() {
        return view('admin.admin-users.index');
    }
}