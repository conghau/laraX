<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 10/11/2016
 * Time: 9:28 PM
 */

namespace App\Repositories\Impl;

use App\Models\SubscribeEmail;
use App\Repositories\Base\BaseRepositoryImpl;
use App\Repositories\SubscribeEmailRepositoryInterface;

/**
 * Class SubscribeEmailRepository
 *
 * @package App\Repositories\Impl
 */
class SubscribeEmailRepository extends BaseRepositoryImpl implements SubscribeEmailRepositoryInterface {
    protected $model;

    public function __construct(SubscribeEmail $model) {
        $this->model = $model;
    }
}