<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 9/17/2016
 * Time: 6:27 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MenuContent extends Model {
    protected $table = 'menu_contents';
    protected $editableFields = [
        'menu_id',
    ];
    protected $primaryKey = 'id';

    public function menu() {
        return $this->belongsTo('App\Models\Menu', 'menu_id');
    }

    public function menuNode() {
        return $this->hasMany('App\Models\MenuNode', 'menu_content_id');
    }
}