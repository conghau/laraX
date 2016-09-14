<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 14/09/2016
 * Time: 10:15
 */

namespace App\Repositories;

use App\Models\Menu;

/**
 * Class MenuRepository
 * @package App\Repositories
 */
class MenuRepository extends BaseRepository {
  public function __construct(Menu $model) {
    parent::__construct($model);
  }
}