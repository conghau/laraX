<?php

/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 12/09/2016
 * Time: 17:43
 */
namespace App\Repositories\Base;
/**
 * Interface BaseRepositoryInterface
 */
interface BaseRepositoryInterface {
    /**
     * Get model
     *
     * @return mixed
     */
    public function getModel();

    /**
     * get all object
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Get list object with pagination
     *
     * @param int $perPage
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($perPage = 10, $columns = ['*']);

    /**
     * Insert/create object
     *
     * @param array $data
     * @param Model $model
     *
     * @return mixed
     */
    public function create(array $data, $model = NULL);

    /**
     * Update object by id
     *
     * @param array $data
     * @param $id
     * @param Model $model
     *
     * @return mixed
     */
    public function update(array $data, $id, $model = NULL);

    /**
     * Delete object by id
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * Get a object by ID
     *
     * @param $id
     * @param array $with
     * @param array $columns
     *
     * @return mixed
     */
    public function findById($id, array $with = array(), $columns = ['*']);

    /**
     * Make ...
     *
     * @param array $with
     *
     * @return mixed
     */
    public function make(array $with = array());

    /**
     * Get list object by pagination
     *
     * @param int $page
     * @param int $limit
     * @param array $with
     *
     * @return mixed
     */
    public function getByPage($page = 1, $limit = 10, $with = array());

    /**
     * Get one by key
     *
     * @param $key
     * @param $value
     * @param array $with
     * @param array $columns
     *
     * @return mixed
     */
    public function getFirstBy($key, $value, array $with = array(), $columns = ['*']);

    /**
     * Get object with condition
     *
     * @param $key
     * @param $value
     * @param array $with
     * @param array $columns
     *
     * @return mixed
     */
    public function getManyBy($key, $value, array $with = array(), $columns = ['*']);

    /**
     * Check relation
     *
     * @param $relation
     * @param array $with
     *
     * @return mixed
     */
    public function has($relation, array $with = array());

    /**
     * Count number object with condition
     *
     * @param array $with
     *
     * @return mixed
     */
    public function count($with = array());

    /**
     * make_array
     *
     * @param array $arrItems , list of item
     * @param $field_key
     * @param $field_value
     *
     * @return mixed
     */
    public function make_array(array $arrItems, $field_key, $field_value);

    /**
     * Get object by where condition
     *
     * @param array $where
     * @param int $page
     * @param int $limit
     * @param array $order_by
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere(array $where, $page = 1, $limit = 10, array $order_by = ['id' => 'asc'], $columns = ['*']);

    /**
     * Get object with condition in
     *
     * @param $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*']);

    /**
     * Get object with condition not in
     *
     * @param $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereNotIn($field, array $values, $columns = ['*']);

    /**
     * Apply condition
     *
     * @param array $condition
     *
     * @return $this
     */
    public function applyCondition(array $condition);

    /**
     * Apply order by
     *
     * @param array $order_by
     *
     * @return $this
     */
    public function applyOrderBy(array $order_by);

    /**
     * Create Or Update
     *
     * @param array $data
     * @return mixed
     */
    public function createOrUpdate(array $data);

    /**
     * First or New
     *
     * @param array $data
     * @return mixed
     */
    public function firstOrNew(array $data);
}