<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 14/09/2016
 * Time: 11:49
 */

namespace App\Http\Controllers\Admin;


use App\Repositories\MenuRepository;

class MenuController extends BaseAdminController {

  protected $menuRepo;

  public function __construct(MenuRepository $menuRepository) {
    parent::__construct();
    $this->menuRepo = $menuRepository;
  }
}