<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 10/8/2016
 * Time: 1:33 PM
 */

namespace App\Repositories\Impl;


use App\Models\AdminUser;
use App\Repositories\AdminUserRepositoryInterface;
use App\Repositories\Base\BaseRepositoryImpl;

/**
 * Class AdminUserRepository
 *
 * @package App\Repositories\Impl
 */
class AdminUserRepository extends BaseRepositoryImpl implements AdminUserRepositoryInterface {
    protected $model;

    public function __construct(AdminUser $model) {
        $this->model = $model;
    }
}