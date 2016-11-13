<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 19/10/2016
 * Time: 17:06
 */

namespace App\Repositories\Impl;


use App\Models\Category;
use App\Repositories\Base\BaseRepositoryImpl;
use App\Repositories\CategoryRepositoryInterface;

/**
 * Class CategoryRepository
 * @package App\Repositories\Impl
 */
class CategoryRepository extends BaseRepositoryImpl implements CategoryRepositoryInterface {
    protected $model;

    public function __construct(Category $model) {
        $this->model = $model;
    }
}