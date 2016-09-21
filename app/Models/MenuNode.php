<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 9/17/2016
 * Time: 6:28 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MenuNode extends Model {
    public function menuContent() {
        return $this->belongsTo('App\Models\MenuContent');
    }

    public function menuNode() {
        return $this->hasMany('App\Models\MenuNode', 'menu_id');
    }

    public function parent() {
        return $this->belongsTo('App\Models\MenuNode', 'parent_id');
    }

    public function child() {
        return $this->hasMany('App\Models\MenuNode', 'parent_id');
    }
}