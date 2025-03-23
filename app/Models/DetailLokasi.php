<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailLokasi extends Model
{
  use HasFactory;

  protected $table = "detail_lokasi";

  protected $fillable = [
    'name',
    'label',
    'category',
    'plan',
  ];
}