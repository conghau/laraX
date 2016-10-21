<?php

/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 12/09/2016
 * Time: 17:45
 */
namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use TCH\LaraXConfig;

/**
 * Class BaseRepositoryImpl
 *
 * @package App\Repositories\Base
 */
abstract class BaseRepositoryImpl implements BaseRepositoryInterface {

    protected $model;
    protected $criteria;

    public function __construct() {
//        $this->model = $model;
        $this->criteria = new Collection();
    }

    public function getModel() {
        return $this->model;
    }

    public function all($columns = array('*')) {
        $result = $this->model->get($columns);
        return $result;
    }

    public function paginate($perPage = 10, $columns = array('*')) {

    }

    public function create(array $data, $model = NULL) {
        try {
            if ($model instanceof Model) {
                return $model->fill($data)->save();
            }
            return $this->model->fill($data)->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update(array $data, $id, $model = NULL) {
        try {
            if ($model instanceof Model) {
                return $model->find($id)->fill($data)->save();
            }
            return $this->model->find($id)->fill($data)->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function delete($id) {
    }

    public function findById($id, array $with = array(), $columns = array('*')) {
        return $this->make($with)->find($id, $columns);
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
        return $this->make($with)
            ->where($key, '=', $value)
            ->get($columns)
            ->first();
    }

    public function has($relation, array $with = array()) {
        return $this->make($with)->has($relation)->get();
    }

    public function count($with = array()) {
        return $this->make($with)->count();
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


    /**
     * {@inheritdoc}
     */
    public function findWhere(array $where, $page = 1, $limit = 10, array $order_by = ['id' => 'asc'], $columns = ['*']) {
        $this->applyCondition($where);
        $this->applyOrderBy($order_by);
        return $this->buildResult($page, $limit);
    }

    public function findWhereIn($field, array $values, $columns = ['*']) {
        return $this->model->whereIn($field, $values)->get($columns);
    }

    public function findWhereNotIn($field, array $values, $columns = ['*']) {
        return $this->model->whereNotIn($field, $values)->get($columns);
    }

    public function applyCondition(array $where) {
        if (empty($where)) {
            return;
        }
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            }
            else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }

    public function applyOrderBy(array $order_by) {
        foreach ($order_by as $field => $value) {
            $this->model = $this->model->orderBy($field, $value);
        }
    }

    public function firstOrNew(array $data) {
        return $this->model->firstOrNew($data);
    }

    protected function buildResult($page = LaraXConfig::PAGE_DEFAULT, $limit = LaraXConfig::LIMIT_DEFAULT, $columns = ['*']) {
        if ($limit < 1) {
            $limit = LaraXConfig::LIMIT_DEFAULT;
        }

        if ($page < 1) {
            $page = LaraXConfig::PAGE_DEFAULT;
        }

        $result = new \stdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();
        $result->totalItems = $this->model->count();
        $result->items = $this->model->skip($limit * ($page - 1))
            ->take($limit)
            ->get($columns);;
        return $result;
    }

    public function createOrUpdate(array $data, $model = NULL) {
        //create
        $id = laraX_get_value($data, 'id', 0);
        try {
            if (0 === $id) {
                return $this->create($data, $model);
            }
            //update
            return $this->update($data, $id, $model);
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

}