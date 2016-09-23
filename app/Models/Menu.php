<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
    public function menuContent() {
        return $this->hasMany('App\Models\MenuContent', 'menu_id');
    }

    public function menuContentNode() {
        return $this->hasManyThrough(
            'App\Models\MenuContent', 'App\Models\MenuNode',
            'id','menu_content_id'
        );
    }
}
