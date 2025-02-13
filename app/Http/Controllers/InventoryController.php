<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function store(Request $request)
    {
        // Validate and store the inventory data
        $request->validate([
            'part_name' => 'required|string|max:255',
            'part_number' => 'required|string|max:255',
            'inventory_code' => 'required|string|max:255',
            'status_product' => 'required|string|in:NG,WIP,FINISH GOOD',
            'qty_box' => 'required|integer|min:0',
            'qty_box_total' => 'required|integer|min:0',
            'qty_box_2' => 'nullable|integer|min:0',
            'qty_box_total_2' => 'nullable|integer|min:0',
            'issued_date' => 'required|date',
            'prepared_by' => 'required|string|max:255',
            'checked_by' => 'required|string|max:255',
        ]);

        // Store the data in the database (example)
        // Inventory::create($request->all());

        return redirect()->route('sto.index')->with('success', 'Inventory data stored successfully.');
    }
}