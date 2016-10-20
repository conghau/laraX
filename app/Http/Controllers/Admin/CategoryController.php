<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 20/10/2016
 * Time: 11:14
 */

namespace App\Http\Controllers\Admin;


use App\Repositories\CategoryRepositoryInterface;


/**
 * Class CategoryController
 * @package App\Http\Controllers\Admin
 */
class CategoryController extends BaseAdminController {

    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository) {
        parent::__construct();
        $this->categoryRepository = $categoryRepository;
    }

    public function getIndex() {
        return view('admin.categories.index');
    }

    public function postIndex() {

    }

}