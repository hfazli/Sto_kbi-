<?php

namespace App\Imports;

use App\Models\Forecast;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ForecastImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Forecast([
            'inventory_id' => $row['inventory_id'],
            'part_name' => $row['part_name'],
            'part_number' => $row['part_number'],
            'customer' => $row['customer'],
            'forecast_qty' => $row['forecast_qty'],
            'min_stok' => $row['min_stok'],
            'max_stok' => $row['max_stok'],
            'forecast_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['forecast_date']),
        ]);
    }
}
