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
        try {
            foreach ($datas as $k => $data) {
                $r = $this->model->firstOrNew(['option_key' => $k]);
                $r->option_value = $data;
                $r->save();
            }
            return TRUE;
        }
        catch (\Exception $e) {
            return FALSE;
        }
    }

    public function getSetting($key) {
        $result = $this->getFirstBy('option_key', $key, [], ['option_value'])
            ->toArray();
        return $result['option_value'];
    }
}