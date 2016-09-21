<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 9/17/2016
 * Time: 4:30 AM
 */

namespace App\Repositories;


use App\Repositories\Base\BaseRepositoryInterface;

/**
 * Interface MenuRepositoryInterface
 * @package App\Repositories
 */
interface MenuRepositoryInterface extends BaseRepositoryInterface {
    public function getItems();
}