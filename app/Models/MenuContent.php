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
    public function menu() {
        return $this->belongsTo('App\Models\Menu');
    }

    public function menuNode() {
        return $this->hasMany('App\Models\MenuNode');
    }
}