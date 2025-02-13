<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $table = 'finished_goods';

    protected $fillable = [
        'inventory_id',
        'part_name',
        'part_number',
        'type_package',
        'qty_package',
        'project',
        'customer',
        'area_fg',
        'satuan'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }


}