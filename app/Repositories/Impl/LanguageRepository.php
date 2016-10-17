<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 03/10/2016
 * Time: 14:00
 */

namespace App\Repositories\Impl;


use App\Models\Language;
use App\Repositories\Base\BaseRepositoryImpl;
use App\Repositories\LanguageRepositoryInterface;

/**
 * Class LanguageRepository
 * 
 * @package App\Repositories\Impl
 */
class LanguageRepository extends BaseRepositoryImpl implements LanguageRepositoryInterface {
  protected $model;

  public function __construct(Language $model) {
    return $this->model = $model;
  }

}