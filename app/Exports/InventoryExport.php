<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventory::all();
    }

    public function headings(): array
    {
        return [
            'No', 'Inventory ID', 'Part Name', 'Part Number', 'Type Package', 'Qty/Box', 'Status Product', 'Project', 'Customer', 'Detail Lokasi', 'Unit', 'Plant', 
        ];
    }
}
