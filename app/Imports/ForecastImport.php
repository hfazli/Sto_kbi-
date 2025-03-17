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
        $forecastData = [
            'inventory_id' => $row['inventory_id'],
            'part_name' => $row['part_name'],
            'part_number' => $row['part_number'],
            'customer' => $row['customer'],
            'forecast_qty' => $row['forecast_qty'],
            'min_stok' => $row['min_stok'],
            'max_stok' => $row['max_stok'],
        ];

        if (isset($row['forecast_date'])) {
            $forecastData['forecast_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['forecast_date']);
        } else {
            // Set a default value for forecast_date if it is not provided
            $forecastData['forecast_date'] = now();
        }

        return new Forecast($forecastData);
    }
}
