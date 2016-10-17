<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 26/09/2016
 * Time: 15:43
 */

namespace App\Repositories\Impl;


use App\Models\Post;
use App\Repositories\Base\BaseRepositoryImpl;
use App\Repositories\PostRepositoryInterface;

/**
 * Class PostRepository
 * 
 * @package App\Repositories\Impl
 */
class PostRepository extends BaseRepositoryImpl implements PostRepositoryInterface {
  public function __construct(Post $model) {
    $this->model = $model;
  }
}