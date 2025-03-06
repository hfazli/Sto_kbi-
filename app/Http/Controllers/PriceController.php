<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;
use App\Imports\PriceImport;
use Maatwebsite\Excel\Facades\Excel;

class PriceController extends Controller
{
    public function index()
    {
        $prices = Price::all();
        return view('Price.index', compact('prices'));
    }

    public function create()
    {
        return view('Price.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required',
            'part_name' => 'required',
            'part_number' => 'required',
            'unit_price' => 'required|numeric',
        ]);

        Price::create($request->all());

        return redirect()->route('price.index')->with('success', 'Price created successfully.');
    }

    public function show(Price $price)
    {
        return view('Price.show', compact('price'));
    }

    public function edit(Price $price)
    {
        return view('Price.edit', compact('price'));
    }

    public function update(Request $request, Price $price)
    {
        $request->validate([
            'inventory_id' => 'required',
            'part_name' => 'required',
            'part_number' => 'required',
            'unit_price' => 'required|numeric',
        ]);

        $price->update($request->all());

        return redirect()->route('price.index')->with('success', 'Price updated successfully.');
    }

    public function destroy(Price $price)
    {
        $price->delete();

        return redirect()->route('price.index')->with('success', 'Price deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        Excel::import(new PriceImport, $request->file('file'));

        return redirect()->route('price.index')->with('success', 'Prices imported successfully.');
    }
}