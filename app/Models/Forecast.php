<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    use HasFactory;

    protected $table = 'Forecast'; // Correct the table name

    protected $fillable = [
        'inventory_id',
        'part_name',
        'part_number',
        'customer',
        'forecast_qty',
        'min_stok',
        'max_stok',
        'forecast_date',
    ];
}