<?php

/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 12/09/2016
 * Time: 17:45
 */
namespace App\Repositories\Base;

use Illuminate\Support\Collection;

/**
 * Class BaseRepositoryImpl
 * @package App\Repositories\Base
 */
abstract class BaseRepositoryImpl {

    protected $model;
    protected $criteria;

    public function __construct() {
//        $this->model = $model;
        $this->criteria = new Collection();
    }

    public function all($columns = array('*')) {
        $result = $this->model->get($columns);
        return $result;
    }

    public function paginate($perPage = 10, $columns = array('*')) {

    }

    public function create(array $data) {

    }

    public function update(array $data, $id) {
        return $this->model->find($id)->fill($data)->save();
    }


    public function delete($id) {
    }

    public function getById($id, array $with = array(), $columns = array('*')) {
        return $this->make($with)->find($id)->get($columns);
    }

    public function make(array $with = array()) {
        return $this->model->with($with);
    }

    public function getByPage($page = 1, $limit = 10, $with = array()) {
        $result = new \stdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->make($with);

        $model = $query->skip($limit * ($page - 1))->take($limit)->get();

        $result->totalItems = $this->model->count();
        $result->items = $model->all();

        return $result;
    }

    public function getManyBy($key, $value, array $with = array(), $columns = array('*')) {
        return $this->make($with)->where($key, '=', $value)->get($columns);
    }

    public function getFirstBy($key, $value, array $with = array(), $columns = array('*')) {
        return $this->make($with)->where($key, '=', $value)->get($columns)->first();
    }

    public function has($relation, array $with = array()) {
        return $this->make($with)->has($relation)->get();
    }

    public function make_array(array $arrItems, $field_key, $field_value) {
        if (!is_array($arrItems)) {
            return [];
        }
        $result = [];
        foreach ($arrItems as $item) {
            if (is_object($item)) {
                continue;
            }
            if (!isset($item[$field_key])) {
                continue;
            }
            $result[$item[$field_key]] = isset($item[$field_value]) ? $item[$field_value] : '';
        }
        return $result;
    }

    public function pushCriteria($criteria) {
    }

    public function popCriteria($criteria) {
    }

    public function getCriteria() {
    }

    public function getByCriteria(CriteriaInterface $criteria) {
    }

    public function skipCriteria($status = TRUE) {
    }

    public function resetCriteria() {
    }
}