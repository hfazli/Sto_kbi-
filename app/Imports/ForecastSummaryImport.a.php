<?php

namespace App\Imports;

use App\Models\ForecastSummary;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ForecastSummaryImport implements ToCollection, WithMultipleSheets
{
  private $sheetName = 'Summary';

  public function sheets(): array
  {
    return [
      $this->sheetName => $this, // Specify the "Summary" sheet
    ];
  }

  public function collection(Collection $rows)
  {
    $startRow = null;
    $lastColIndex = null;
    $dateColumns = [];
    $stockDays = [0, 0.5, 1, 1.5, 2, 2.5, 3, '>3'];

    // Find the starting row (where "Customer" is found in column B)
    foreach ($rows as $index => $row) {
      if (isset($row[1]) && strtolower(trim($row[1])) === "customer") {
        $startRow = $index + 1; // Data starts from the next row
        break;
      }
    }

    if ($startRow === null) {
      throw new \Exception("Header row not found in '{$this->sheetName}' sheet.");
    }

    // Extract date columns
    $headerRow = $rows[$startRow - 1];
    for ($colIndex = 5; $colIndex < count($headerRow); $colIndex++) {
      $cellValue = $headerRow[$colIndex] ?? '';

      // Stop processing if we reach "AVG"
      if (strtoupper(trim($cellValue)) === "AVG") {
        $lastColIndex = $colIndex - 1;
        break;
      }

      if (is_numeric($cellValue)) {
        $date = ExcelDate::excelToDateTimeObject($cellValue);
        $formattedDate = $date->format('Y-m-d');
        $dateColumns[$colIndex] = $formattedDate;
      } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $cellValue)) {
        $date = Carbon::createFromFormat('d/m/Y', $cellValue);
        $formattedDate = $date->format('Y-m-d');
        $dateColumns[$colIndex] = $formattedDate;
      } else {
        if (!empty($dateColumns)) {
          $lastDate = Carbon::createFromFormat('Y-m-d', end($dateColumns));
          $formattedDate = $lastDate->addDay()->format('Y-m-d');
          $dateColumns[$colIndex] = $formattedDate;
        } else {
          break;
        }
      }
    }

    // Process data rows
    $currentCustomer = null;

    foreach ($rows as $index => $row) {
      if ($index < $startRow) continue; // Skip headers

      if (!empty($row[1])) { // Column B - Customer Name
        $currentCustomer = $row[1];
      }

      if ($currentCustomer) {
        $stockDayIndex = ($index - $startRow) % 8;

        if ($stockDayIndex < count($stockDays)) {
          foreach ($dateColumns as $colIndex => $date) {
            $forecastData = [
              'customer_name' => $this->getCellValue($row, 1), // Column B
              'dec' => $this->getCellValue($row, 2), // Column C
              'total_part' => $this->getCellValue($row, 3), // Column D
              'stock_day' => $stockDays[$stockDayIndex] ?? null, // 0, 0.5, 1, etc.
              'date' => $date, // Dynamic date from dateColumns
              'stock_value' => $this->getCellValue($row, $colIndex), // Column F to last date column
              'avg' => $this->getCellValue($row, $lastColIndex + 1), // AVG column is right after last date column
            ];

            // Debugging
            dd($forecastData); // Uncomment for debugging

            // Save to DB
            ForecastSummary::create($forecastData);
          }
        }
      }
    }
  }

  private function getCellValue($row, int $index)
  {
    if (!isset($row[$index])) {
      return null;
    }

    $cell = $row[$index];

    // Check if the cell contains a formula
    if ($cell instanceof \PhpOffice\PhpSpreadsheet\Cell\Cell) {
      return $cell->getCalculatedValue(); // Get the evaluated result
    }

    return $cell; // Return normal value
  }
}
