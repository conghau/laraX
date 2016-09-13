<?php

/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 12/09/2016
 * Time: 17:49
 */

namespace App\Repositories;
/**
 * Class SettingRepository
 */
class SettingRepository extends BaseRepository {
    protected $model;

    public function __construct(\App\Models\Setting $model) {
        $this->model = $model;
    }

    public function getAllSetting() {
        $result = $this->all()->toArray();
        return $this->make_array($result,'key', 'value');

    }
}