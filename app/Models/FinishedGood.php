<?php
// filepath: /d:/STO-master/STO-master/app/Models/FinishedGood.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishedGood extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'part_name',
        'part_number',
        'type_package',
        'qty_package',
        'project',
        'customer',
        'area_fg',
        'satuan',
        'stok_awal', // New column
    ];
}