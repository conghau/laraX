<?php

/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 12/09/2016
 * Time: 17:49
 */

/**
 * Class SettingRepository
 */
class SettingRepository extends RepositoryAbstract implements RepositoryInterface {
  protected $model;

  public function __construct(\App\Setting $model) {
    $this->model = $model;
  }
}