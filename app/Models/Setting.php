<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $editableFields = [
        'key',
        'value',
    ];

    protected $fillable = [
        'key',
        'value',
    ];

    protected $table = 'settings';
}
