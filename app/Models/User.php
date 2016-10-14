<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_name',
    'email',
    'password',
    'last_name',
    'first_name',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'status' => 'boolean',
  ];

  public function getFullNameAttribute() {
    return $this->fist_name . ' ' . $this->last_name;
  }
}
