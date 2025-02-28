<?php

namespace App\Imports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class InventoryImport implements ToModel, WithHeadingRow, WithStartRow
{
    public $errorRows = [];
    public $successfulRows = [];

    public function startRow(): int
    {
        return 2; // Mulai dari baris ke-2, menghindari header yang salah
    }

    public function model(array $row)
    {
        // Ubah semua kunci menjadi huruf kecil untuk menghindari ketidaksesuaian header
        $row = array_change_key_case($row, CASE_LOWER);

        // Cast inventory_id to string to handle numeric values
        $row['inventory_id'] = (string) $row['inventory_id'];

        // Debugging opsional untuk melihat isi row (aktifkan jika perlu)
        // dd($row);

        // Validasi data
        $validator = Validator::make($row, [
            'inventory_id' => 'required|string|max:255',
            'part_name' => 'required|string|max:255',
            'part_number' => 'required|string|max:255',
            'type_package' => 'required|string|max:255',
            'qty_package' => 'required|integer|min:1', // Pastikan qty_package lebih dari 0
            'project' => 'nullable|string|max:255',
            'customer' => 'required|string|max:255',
            'detail_lokasi' => 'nullable|string|max:255',
            'satuan' => 'required|string|max:255',
            'plant' => 'required|string|max:255',
            'status_product' => 'required|string|max:255', // Add validation for status_product
        ]);

        if ($validator->fails()) {
            $this->errorRows[] = [
                'row' => $row,
                'errors' => $validator->errors()->all(),
            ];
            Log::error('Validation failed for row: ', ['row' => $row, 'errors' => $validator->errors()->all()]);
            return null;
        }

        // Cek apakah data sudah ada berdasarkan kunci unik
        $existingInventory = Inventory::where('inventory_id', $row['inventory_id'])
            ->where('part_number', $row['part_number'])
            ->first();

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            if ($existingInventory) {
                // Jika sudah ada, update data
                $existingInventory->update([
                    'part_name' => $row['part_name'],
                    'type_package' => $row['type_package'],
                    'qty_package' => $row['qty_package'],
                    'project' => $row['project'],
                    'customer' => $row['customer'],
                    'detail_lokasi' => $row['detail_lokasi'],
                    'satuan' => $row['satuan'],
                    'plant' => $row['plant'],
                    'status_product' => $row['status_product'], // Add this line
                ]);
                $this->successfulRows[] = $existingInventory;
            } else {
                // Jika belum ada, buat data baru
                $inventory = Inventory::create([
                    'inventory_id' => $row['inventory_id'],
                    'part_name' => $row['part_name'],
                    'part_number' => $row['part_number'],
                    'type_package' => $row['type_package'],
                    'qty_package' => $row['qty_package'],
                    'project' => $row['project'],
                    'customer' => $row['customer'],
                    'detail_lokasi' => $row['detail_lokasi'],
                    'satuan' => $row['satuan'],
                    'plant' => $row['plant'],
                    'status_product' => $row['status_product'], // Add this line
                ]);
                $this->successfulRows[] = $inventory;
            }

            DB::commit(); // Commit jika berhasil
            return $existingInventory ?? $inventory;
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika gagal
            $this->errorRows[] = [
                'row' => $row,
                'errors' => ['Error saving data: ' . $e->getMessage()],
            ];
            Log::error('Exception occurred while saving row: ', ['row' => $row, 'exception' => $e->getMessage()]);
            return null;
        }
    }

    public function getErrorRows()
    {
        return $this->errorRows;
    }

    public function getSuccessfulRows()
    {
        return $this->successfulRows;
    }
}