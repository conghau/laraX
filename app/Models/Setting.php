<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $editableFields = [
        'option_key',
        'option_value',
    ];

    protected $fillable = [
        'option_key',
        'option_value',
    ];

    protected $table = 'settings';
}
