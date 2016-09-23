<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 21/09/2016
 * Time: 12:38
 */

namespace App\Http\Controllers\Admin;


class PostController extends BaseAdminController {

  protected $postRepo;

  public function __construct() {
    parent::__construct();
  }
}