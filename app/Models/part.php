<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_name',
        'part_number',
        'type_package',
        'qty_package',
        'min_value',
        'max_value',
        'created_at',
        'updated_at',
    ];
}