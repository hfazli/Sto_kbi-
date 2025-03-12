<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForecastSummary extends Model
{
  use HasFactory;

  protected $fillable = [
    'customer_name',
    'dec',
    'total_part',
    'stock_day',
    'date',
    'stock_value',
    'avg'
  ];
}
