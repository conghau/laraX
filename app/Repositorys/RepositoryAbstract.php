<?php

/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 12/09/2016
 * Time: 17:45
 */
abstract class RepositoryAbstract {

  public function all() {
    $this->model->all();
  }

  public function paginate($perPage = 10, $columns = array('*')) {

  }

  public function create(array $data) {

  }

  public function update(array $data, $id) {
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
}