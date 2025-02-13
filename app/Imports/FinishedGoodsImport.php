<?php

namespace App\Imports;

use App\Models\FinishedGood;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class FinishedGoodsImport implements ToModel, WithHeadingRow, WithStartRow
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
            'area_fg' => 'nullable|string|max:255',
            'satuan' => 'required|string|max:255',
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
        $existingFinishedGood = FinishedGood::where('inventory_id', $row['inventory_id'])
            ->where('part_number', $row['part_number'])
            ->first();

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            if ($existingFinishedGood) {
                // Jika sudah ada, update data
                $existingFinishedGood->update([
                    'part_name' => $row['part_name'],
                    'type_package' => $row['type_package'],
                    'qty_package' => $row['qty_package'],
                    'project' => $row['project'],
                    'customer' => $row['customer'],
                    'area_fg' => $row['area_fg'],
                    'satuan' => $row['satuan'],
                ]);
                $this->successfulRows[] = $existingFinishedGood;
            } else {
                // Jika belum ada, buat data baru
                $finishedGood = FinishedGood::create([
                    'inventory_id' => $row['inventory_id'],
                    'part_name' => $row['part_name'],
                    'part_number' => $row['part_number'],
                    'type_package' => $row['type_package'],
                    'qty_package' => $row['qty_package'],
                    'project' => $row['project'],
                    'customer' => $row['customer'],
                    'area_fg' => $row['area_fg'],
                    'satuan' => $row['satuan'],
                ]);
                $this->successfulRows[] = $finishedGood;
            }

            DB::commit(); // Commit jika berhasil
            return $existingFinishedGood ?? $finishedGood;
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