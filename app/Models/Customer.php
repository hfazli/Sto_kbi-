<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'tbl_customer';
    protected $fillable = [
        'name',
        'username'
    ];

    // Definisi relasi ke model Project
    public function projects()
    {
        return $this->hasMany(Project::class, 'customer_id', 'id');
    }
}
