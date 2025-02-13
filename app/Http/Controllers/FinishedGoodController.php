<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinishedGood;
use App\Models\Customer;
use App\Imports\FinishedGoodsImport;
use Maatwebsite\Excel\Facades\Excel;use PDF; // Ensure you have the barryvdh/laravel-dompdf package installed

class FinishedGoodController extends Controller
{
    public function index(Request $request)
    {
        $entries = $request->get('entries', 'all'); // Default to 'all' entries per page
        $search = $request->get('search'); // Get the search query

        $query = FinishedGood::query();

        if ($search) {
            $query->where('customer', 'like', '%' . $search . '%');
        }

        if ($entries == 'all') {
            $finishedGoods = $query->get();
        } else {
            $finishedGoods = $query->paginate($entries);
        }

        return view('finished_goods.index', compact('finishedGoods', 'search'));
    }

    public function create()
    {
        $customers = Customer::all(); // Ambil semua data customer
        return view('finished_goods.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|string|max:255',
            'part_name' => 'required|string|max:255',
            'part_number' => 'required|string|max:255',
            'type_package' => 'required|string|max:255',
            'qty_package' => 'required|integer',
            'project' => 'nullable|string|max:255',
            'customer' => 'required|string|max:255',
            'area_fg' => 'nullable|string|max:255',
            'plant' => 'nullable|string|max:255', // Add this line
            'satuan' => 'required|string|max:255',
        ]);

        $finishedGood = new FinishedGood();
        $finishedGood->inventory_id = $request->inventory_id;
        $finishedGood->part_name = $request->part_name;
        $finishedGood->part_number = $request->part_number;
        $finishedGood->type_package = $request->type_package;
        $finishedGood->qty_package = $request->qty_package;
        $finishedGood->project = $request->project;
        $finishedGood->customer = $request->customer;
        $finishedGood->area_fg = $request->area_fg;
        $finishedGood->satuan = $request->satuan;

        $finishedGood->save();

        return redirect()->route('finished_goods.index')->with('success', 'Finished Good created successfully.');
    }

    public function show($id)
    {
        $finishedGood = FinishedGood::findOrFail($id);
        return view('finished_goods.show', compact('finishedGood'));
    }

    public function edit($id)
    {
        $finishedGood = FinishedGood::findOrFail($id);
        $customers = Customer::all();
        return view('finished_goods.edit', compact('finishedGood', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'inventory_id' => 'required|string|max:255',
            'part_name' => 'required|string|max:255',
            'part_number' => 'required|string|max:255',
            'type_package' => 'required|string|max:255',
            'qty_package' => 'required|integer',
            'project' => 'nullable|string|max:255',
            'customer' => 'required|string|max:255',
            'area_fg' => 'nullable|string|max:255',
            'satuan' => 'required|string|max:255',
        ]);

        $finishedGood = FinishedGood::findOrFail($id);
        $finishedGood->update($request->all());

        return redirect()->route('finished_goods.index')->with('success', 'Finished Good updated successfully.');
    }

    public function destroy($id)
    {
        $finishedGood = FinishedGood::findOrFail($id);
        $finishedGood->delete();

        return redirect()->route('finished_goods.index')->with('success', 'Finished Good deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $import = new FinishedGoodsImport;
        Excel::import($import, $request->file('file'));

        if (count($import->getErrorRows()) > 0) {
            return redirect()->route('finished_goods.index')->with('error', 'Some rows failed to import.');
        }

        return redirect()->route('finished_goods.index')->with('success', 'Finished Goods imported successfully.');
    }

    public function showUploadForm()
    {
        return view('finished_goods.upload');
    }
    public function downloadPdf()
    {
        $finishedGoods = FinishedGood::all();
        $pdf = PDF::loadView('finished_goods.pdf', compact('finishedGoods'));
        return $pdf->download('finished_goods.pdf');
    }
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        Excel::import(new FinishedGoodsImport, $file);

        return redirect()->route('finished_goods.index')->with('success', 'Finished goods uploaded successfully.');
    }

    public function changeStatus($id, Request $request)
    {
        $finishedGood = FinishedGood::find($id);
        if ($finishedGood) {
            $finishedGood->status = $request->status;
            $finishedGood->save();

            return response()->json(['success' => true, 'message' => 'Status berhasil diubah.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Finished Good tidak ditemukan.']);
        }
    }
}