<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 10/9/2016
 * Time: 8:15 PM
 */

namespace App\Http\Controllers\Admin;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Admin
 */
class UserController extends BaseAdminController {
    public function __construct() {
        parent::__construct('users');
    }

    public function getIndex() {
        return view('admin.users.index');
    }
}