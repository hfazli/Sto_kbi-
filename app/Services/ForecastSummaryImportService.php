<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ForecastSummaryImportService
{
  public function import($filePath)
  {
    // Load the Excel file
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getSheetByName('Summary'); // Get specific sheet
    $data = [];

    if (!$sheet) {
      throw new \Exception("Sheet 'Summary' not found!");
    }

    $rows = $sheet->toArray(null, true, true, true); // Convert to array

    $startRow = null;
    $dateColumns = [];
    $stockDays = [0, 0.5, 1, 1.5, 2, 2.5, 3, '>3'];

    // Find the starting row (header row where "Customer" exists)
    foreach ($rows as $index => $row) {
      if (isset($row['B']) && strtolower(trim($row['B'])) === "customer") {
        $startRow = $index + 1; // Data starts from next row
        break;
      }
    }

    if (!$startRow) {
      throw new \Exception("Header row not found in 'Summary' sheet.");
    }

    // Extract date columns
    $headerRow = $rows[$startRow - 1];
    foreach ($headerRow as $col => $cellValue) {
      if (strtoupper(trim($cellValue)) === "AVG") break;

      if (is_numeric($cellValue)) {
        $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cellValue)->format('Y-m-d');
        $dateColumns[$col] = $date;
      }
    }

    // Process rows
    $currentCustomer = null;
    foreach ($rows as $index => $row) {
      if ($index < $startRow) continue;

      if (!empty($row['B'])) {
        $currentCustomer = $row['B'];
      }

      if ($currentCustomer) {
        $stockDayIndex = ($index - $startRow) % 8;
        if ($stockDayIndex < count($stockDays)) {
          foreach ($dateColumns as $colIndex => $date) {
            $data[] = [
              'customer_name' => $row['B'] ?? null,
              'dec' => $row['C'] ?? null,
              'total_part' => $row['D'] ?? null,
              'stock_day' => $stockDays[$stockDayIndex] ?? null,
              'date' => $date,
              'stock_value' => $this->getRealValue($sheet, $colIndex, $index), // Get real value
              'avg' => $this->getRealValue($sheet, $colIndex + 1, $index),
            ];
          }
        }
      }
    }

    return $data; // Return the processed data
  }

  private function getRealValue($sheet, $colIndex, $rowIndex)
  {
    $cell = $sheet->getCellByColumnAndRow($colIndex, $rowIndex);
    return $cell->getCalculatedValue(); // Get the actual value, not the formula
  }
}
