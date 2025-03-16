<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;


class Admin extends User
{
  use HasApiTokens, HasFactory;

  protected static function boot()
  {
    parent::boot();
    static::addGlobalScope('admin', function (Builder $builder) {
      $builder->where('role', 'admin');
    });
  }

  protected $table = 'users';
  protected $fillable = [
    'first_name',
    'last_name',
    'username',
    'role',
    'password',
    'id_card_number',
    'department',
    'last_login',
  ];

  protected $hidden = [
    'password',
  ];
}
