<?php

namespace App\Exports;

use App\Models\ReportSTO;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return ReportSTO::select('report_sto.inventory_id', 'inventory.part_name', 'inventory.part_number', 'report_sto.grand_total', 'report_sto.detail_lokasi')
            ->join('inventory', 'report_sto.inventory_id', '=', 'inventory.inventory_id')
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
            'username',
        ];
    }
}