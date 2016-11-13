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
use Illuminate\Support\Facades\Log;
use TCH\LaraXConfig;
use TCH\LaraXException;

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
                $model->fill($data)->save();
                return $model->id;
            }
            return $this->model->fill($data)->save();
        } catch (LaraXException $e) {
            throw $e;
        }
    }

    public function update(array $data, $id, $model = NULL) {
        try {
//            if (isset($data['id'])) unset($data['id']);
            if ($model instanceof Model) {
                $model->findOrFail($id)->update($data);
                return $model->id;
            }

            $this->model->findOrFail($id)->update($data);
            return $this->model->id;
        } catch (\Exception $e) {
            throw $e;
            //Log::error(json_encode(['action' => 'update', 'message' => $e->getMessage(), 'data' => $data]));
            return 0;
        }
    }


    public function delete($id) {
        $this->model->destroy($id);
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
            } else {
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

    public function save(array $data) {
        return '';
    }

    public function deletes(array $ids) {
        $this->model->destroy($ids);
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

    /**
     * Create Or Update
     *
     * @param array $data
     * @param null $model
     * @param string $message_err is ref
     * @param bool $throw_ex
     *
     * @return id of record if save success otherwise return 0 or exception
     */
    public function createOrUpdate(array $data, $model = NULL, &$message_err = '', $throw_ex = FALSE) {
        $id = laraX_get_value($data, 'id', 0);
        try {
            //case insert
            if (0 == $id) {
                if ($model instanceof Model) {
                    $model->fill($data)->save();
                    return $model->id;
                }
                $this->model->fill($data)->save();
                return $this->model->id;
            }
            //case update
            if ($model instanceof Model) {
                $model->findOrFail($id)->update($data);
            } else {
                $this->model->findOrFail($id)->update($data);
            }
            return $id;
        } catch (\Exception $e) {
            Log::error(json_encode(['action' => 'createOrUpdate', 'type' => get_class($e), 'message' => $e->getMessage(), 'data' => $data]));
            $message_err = $e->getMessage();
            if ($throw_ex) {
                throw $e;
            }
            return 0;
        }
    }
}