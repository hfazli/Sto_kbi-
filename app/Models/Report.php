<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural of the model name
    protected $table = 'reports';

    // Define the fillable attributes
    protected $fillable = [
        'report_id',
        'title',
        'description',
    ];
}