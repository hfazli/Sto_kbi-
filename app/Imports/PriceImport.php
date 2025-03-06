<?php

namespace App\Imports;

use App\Models\Price;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PriceImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Price([
            'inventory_id' => $row['inventory_id'],
            'part_name' => $row['part_name'],
            'part_number' => $row['part_number'],
            'unit_price' => $row['unit_price'],
        ]);
    }
}