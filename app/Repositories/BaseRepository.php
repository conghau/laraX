<?php

/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 12/09/2016
 * Time: 17:45
 */
namespace App\Repositories;

use Illuminate\Support\Collection;

abstract class BaseRepository implements RepositoryInterface, CriteriaInterface {

    protected $model;
    protected $criteria;

    public function __construct($model = null) {
        $this->model = $model;
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
        return $this->model->where()->fill($data)->save();
    }


    public function delete($id) {
    }

    public function find($id, $columns = array('*')) {
    }

    public function findBy($field, $value, $columns = array('*')) {
    }

    public function make(array $with = array()) {
        return $this->model->with($with);
    }

    public function getByPage($page = 1, $limit = 10, $with = array()) {

    }

    public function getFirstBy($key, $value, array $with = array()) {

    }

    public function has($relation, array $with = array()) {

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

    public function skipCriteria($status = true) {
    }

    public function resetCriteria() {
    }
}