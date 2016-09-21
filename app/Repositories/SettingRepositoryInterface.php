<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 9/17/2016
 * Time: 4:38 AM
 */

namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;

/**
 * Interface SettingRepositoryInterface
 * @package App\Repositories
 */
interface SettingRepositoryInterface extends BaseRepositoryInterface {
    public function getAllSetting();
    public function updateSetting(array $data = array());
}