<?php

/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 12/09/2016
 * Time: 17:43
 */
namespace App\Repositories;
/**
 * Interface RepositoryInterface
 */
interface RepositoryInterface {
    public function all($columns = array('*'));

    public function paginate($perPage = 10, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));

    public function make(array $with = array());

    public function getByPage($page = 1, $limit = 10, $with = array());

    public function getFirstBy($key, $value, array $with = array());

    public function has($relation, array $with = array());

    /**
     * make_array
     * @param array $arrItems , list of item
     * @param $field_key
     * @param $field_value
     * @return mixed
     */
    public function make_array(array $arrItems, $field_key, $field_value);
}