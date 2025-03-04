<?php

namespace App\Exports;

use App\Models\ReportSTO;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return ReportSTO::select('report_sto.inventory_id', 'inventory.part_name', 'inventory.part_number', 'report_sto.grand_total', 'report_sto.detail_lokasi', 'users.username')
            ->join('inventory', 'report_sto.inventory_id', '=', 'inventory.inventory_id')
            ->join('users', 'report_sto.prepared_by', '=', 'users.id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Inventory',
            'Part Name',
            'Part Number',
            'Grand Total',
            'Detail Lokasi',
            'Username',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        $sheet->getStyle('A2:F' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        return [];
    }
}