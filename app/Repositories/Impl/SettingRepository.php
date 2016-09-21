<?php

/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 12/09/2016
 * Time: 17:49
 */

namespace App\Repositories\Impl;

use App\Models\Setting;
use App\Repositories\Base\BaseRepositoryImpl;
use App\Repositories\SettingRepositoryInterface;

/**
 * Class SettingRepository
 */
class SettingRepository extends BaseRepositoryImpl implements SettingRepositoryInterface {
    protected $model;

    public function __construct(Setting $model) {
        $this->model = $model;
    }

    public function getAllSetting() {
        $result = $this->all()->toArray();
        return $this->make_array($result, 'option_key', 'option_value');

    }

    public function updateSetting(array $datas = array()) {
        foreach ($datas as $k => $data) {
            $re = $this->getFirstBy('option_key', $k);
            $re->setAttribute('option_value', $data);
            continue;
            $objTemp = new Setting();
//            $objTemp->key = $k;
//            $objTemp->value = $data;
            $objTemp->update(array('key' => $k, 'value' => $data));
        }
        //$this->model->
    }
}