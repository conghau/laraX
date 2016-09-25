<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 9/17/2016
 * Time: 4:30 AM
 */

namespace App\Repositories;


use App\Repositories\Base\BaseRepositoryInterface;

/**
 * Interface MenuRepositoryInterface
 * @package App\Repositories
 */
interface MenuRepositoryInterface extends BaseRepositoryInterface {
    public function getItems();

    public function getMenuContents($menu_slug, $colums = array('*'));

    public function getMenuNodes($menu_content_id, $parent_id = 0, $column = array('*'));

    public function getMenuNodesChild($menu_content_id, $parent_id = 0, $column = array('*'));

    public function getMenuNodesToArray($menu_content_id, $columns = array('*'));
}