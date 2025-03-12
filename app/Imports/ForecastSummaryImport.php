<?php

namespace App\Imports;

use App\Models\ForecastSummary;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class ForecastSummaryImport implements ToModel, WithMultipleSheets, WithCalculatedFormulas
{
  private $sheetName = 'Summary';
  private $startRow = 83;
  private $lastColIndex;
  private $dateColumns = [];
  private $stockDays = [0, 0.5, 1, 1.5, 2, 2.5, 3, '>3'];

  public function sheets(): array
  {
    return [$this->sheetName => $this]; // Process only the "Summary" sheet
  }

  public function model(array $row)
  {
    // Skip header detection
    if ($this->startRow === null) {
      $this->detectHeader($row);
      return null;
    }

    // Skip non-data rows
    if ($this->startRow > count($row)) {
      return null;
    }

    dd($row);

    // Process row data
    return $this->processRow($row);
  }

  private function detectHeader(array $row)
  {
    foreach ($row as $index => $cell) {
      if (isset($cell) && strtolower(trim($cell)) === "customer") {
        $this->startRow = $index + 1;
        break;
      }
    }
  }

  private function processRow(array $row)
  {
    $customerName = $this->getCellValue($row, 1);
    $stockDayIndex = (count($row) - $this->startRow) % 8;

    if ($stockDayIndex < count($this->stockDays)) {
      foreach ($this->dateColumns as $colIndex => $date) {
        return new ForecastSummary([
          'customer_name' => $customerName,
          'dec' => $this->getCellValue($row, 2),
          'total_part' => $this->getCellValue($row, 3),
          'stock_day' => $this->stockDays[$stockDayIndex] ?? null,
          'date' => $date,
          'stock_value' => $this->getCellValue($row, $colIndex),
          'avg' => $this->getCellValue($row, $this->lastColIndex + 1),
        ]);
      }
    }

    return null;
  }

  private function getCellValue($row, int $index)
  {
    return isset($row[$index]) ? (is_numeric($row[$index]) ? $row[$index] : trim((string)$row[$index])) : null;
  }
}
