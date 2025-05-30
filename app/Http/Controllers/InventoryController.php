<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Customer;
use App\Imports\InventoryImport;
use App\Exports\InventoryExport;
use App\Models\DetailLokasi;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
  public function index(Request $request)
  {
    $entries = $request->get('entries', 'all'); // Default to 'all' entries per page
    $search = $request->get('search'); // Get the search query

    $query = Inventory::query();

    if ($search) {
      $query->where('customer', 'like', '%' . $search . '%');
    }

    if ($entries == 'all') {
      $inventory = $query->get();
    } else {
      $inventory = $query->paginate($entries);
    }

    return view('Inventory.index', compact('inventory', 'search'));
  }

  public function create()
  {
    $detail_lokasi = DetailLokasi::all();
    $customers = Customer::all(); // Fetch all customers from the database
    return view('Inventory.create', compact('customers', 'detail_lokasi'));
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
      'detail_lokasi' => 'nullable|string|max:255',
      'satuan' => 'required|string|max:255',
      'plant' => 'nullable|string|max:255',
      'status_product' => 'required|string|max:255', // Add validation for status_product
    ]);

    $inventory = new Inventory();
    $inventory->inventory_id = $request->inventory_id;
    $inventory->part_name = $request->part_name;
    $inventory->part_number = $request->part_number;
    $inventory->type_package = $request->type_package;
    $inventory->qty_package = $request->qty_package;
    $inventory->project = $request->project;
    $inventory->customer = $request->customer;
    $inventory->detail_lokasi = $request->detail_lokasi;
    $inventory->satuan = $request->satuan;
    $inventory->plant = $request->plant;
    $inventory->status_product = $request->status_product; // Save status_product

    $inventory->save();

    return redirect()->route('inventory.index')->with('success', 'Inventory created successfully.');
  }

  public function show($id)
  {
    $inventory = Inventory::findOrFail($id);
    return view('Inventory.show', compact('Inventory'));
  }

  public function edit($id)
  {
    $inventory = Inventory::findOrFail($id); // Fetch the inventory item
    $customers = Customer::all(); // Fetch all customers from the database
    $detail_lokasi = DetailLokasi::all();
    return view('Inventory.edit', compact('inventory', 'customers', 'detail_lokasi'));
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
      'detail_lokasi' => 'nullable|string|max:255',
      'satuan' => 'required|string|max:255',
      'status_product' => 'required|string|max:255',
    ]);

    $inventory = Inventory::findOrFail($id);
    $inventory->update($request->all());

    return redirect()->route('inventory.index')->with('success', 'Inventory updated successfully.');
  }

  public function destroy($id)
  {
    $inventory = Inventory::findOrFail($id);
    $inventory->delete();

    return redirect()->route('inventory.index')->with('success', 'Inventory deleted successfully.');
  }

  public function import(Request $request)
  {
    $request->validate([
      'file' => 'required|mimes:xls,xlsx',
    ]);

    $import = new InventoryImport;
    Excel::import($import, $request->file('file'));

    if (count($import->getErrorRows()) > 0) {
      return redirect()->route('inventory.index')->with('error', 'Some rows failed to import.');
    }

    return redirect()->route('inventory.index')->with('success', 'Inventory imported successfully.');
  }

  public function showUploadForm()
  {
    return view('inventory.upload');
  }

  public function upload(Request $request)
  {
    $request->validate([
      'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    $file = $request->file('file');
    Excel::import(new InventoryImport, $file);

    return redirect()->route('inventory.index')->with('success', 'Inventory uploaded successfully.');
  }

  public function changeStatus($id, Request $request)
  {
    $inventory = Inventory::find($id);
    if ($inventory) {
      $inventory->status_product = $request->status_product; // Update status_product
      $inventory->save();

      return redirect()->route('inventory.index')->with('success', 'Status berhasil diubah.');
    } else {
      return redirect()->route('inventory.index')->with('error', 'Inventory tidak ditemukan.');
    }
  }

  public function scanInventory(Request $request)
  {
    $inventoryId = $request->input('inventory_id');
    $inventory = Inventory::where('inventory_id', $inventoryId)->first();

    if ($inventory) {
      return view('inventory.scan', compact('inventory'));
    } else {
      return redirect()->route('inventory.index')->with('error', 'Inventory not found');
    }
  }

  public function showForm($inventory_id)
  {
    $inventory = Inventory::where('inventory_id', $inventory_id)->first();

    if ($inventory) {
      return view('STO.from', compact('inventory'));
    } else {
      return redirect()->route('sto.index')->with('notfound', 'Inventory not found');
    }
  }

  public function export()
  {
    return Excel::download(new InventoryExport, 'inventory.xlsx');
  }
}
