<?php

namespace App\Imports;

use App\Models\Wip;
use Maatwebsite\Excel\Concerns\ToModel;

class WipImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Wip([
            'inventory_id' => $row[0],
            'part_name' => $row[1],
            'part_number' => $row[2],
            'type_package' => $row[3],
            'qty_per_package' => $row[4],
            'project' => $row[5],
            'customer' => $row[6],
            'location_rak' => $row[7],
            'status' => $row[8],
        ]);
    }
}
