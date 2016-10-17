<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 17/10/2016
 * Time: 17:55
 */

namespace App\Http\Controllers\Admin;


class FileController extends BaseAdminController {
  public function __construct() {
    parent::__construct('files');
  }
}