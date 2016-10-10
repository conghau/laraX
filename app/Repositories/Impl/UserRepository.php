<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 10/8/2016
 * Time: 10:15 PM
 */

namespace App\Repositories\Impl;


use App\Models\User;
use App\Repositories\Base\BaseRepositoryImpl;
use App\Repositories\UserRepositoryInterface;

/**
 * Class UserRepository
 *
 * @package App\Repositories\Impl
 */
class UserRepository extends BaseRepositoryImpl implements UserRepositoryInterface {
    protected $model;

    public function __construct(User $model) {
        return $this->model = $model;
    }
}