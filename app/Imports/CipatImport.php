<?php

namespace App\Imports;

use App\Models\Cipat;
use Maatwebsite\Excel\Concerns\ToModel;

class CipatImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Cipat([
            'name' => $row[0],
            'description' => $row[1],
            // Tambahkan kolom lain sesuai kebutuhan
        ]);
    }
}
