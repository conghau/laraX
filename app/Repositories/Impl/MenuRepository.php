<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 14/09/2016
 * Time: 10:15
 */

namespace App\Repositories\Impl;

use App\Models\Menu;
use App\Repositories\Base\BaseRepositoryImpl;
use App\Repositories\MenuRepositoryInterface;

/**
 * Class MenuRepository
 * @package App\Repositories
 */
class MenuRepository extends BaseRepositoryImpl implements MenuRepositoryInterface {
//    protected $model = 'App\Models\Menu';
    public function __construct(Menu $model) {
        $this->model = $model;
    }

    public function getItems() {
//        $this->model->leftjoin
        $this->model->menuContentNode()->get();
    }
}