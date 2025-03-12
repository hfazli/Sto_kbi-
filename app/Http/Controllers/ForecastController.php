<?php

namespace App\Http\Controllers;

use App\Models\Forecast;
use App\Models\Inventory; // Import the Inventory model
use App\Models\Customer; // Import the Customer model
use Illuminate\Http\Request;
use App\Imports\ForecastImport; // Import the ForecastImport class
use App\Imports\ForecastSummaryImport;
use App\Models\ForecastSummary;
use App\Services\ForecastSummaryImportService;
use Maatwebsite\Excel\Facades\Excel; // Import the Excel facade

class ForecastController extends Controller
{
  public function index(Request $request)
  {
    $query = Forecast::query();

    if ($request->has('start_date') && $request->has('end_date')) {
      $startDate = $request->input('start_date');
      $endDate = $request->input('end_date');
      $query->whereBetween('forecast_date', [$startDate, $endDate]);
    }

    $forecasts = $query->get();
    return view('forecast.index', compact('forecasts'));
  }

  public function create()
  {
    $inventory = Inventory::all(); // Fetch all inventory items
    $customers = Customer::all(); // Fetch all customers
    return view('forecast.create', compact('inventory', 'customers'));
  }

  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'inventory_id' => 'required|string|max:255',
      'part_name' => 'required|string|max:255',
      'part_number' => 'required|string|max:255',
      'customer' => 'required|string|max:255',
      'forecast_qty' => 'required|integer',
      'min_stok' => 'required|integer',
      'max_stok' => 'required|integer',
      'forecast_date' => 'required|date',
    ]);

    Forecast::create($validatedData);

    return redirect()->route('forecast.index')->with('success', 'Forecast created successfully.');
  }

  public function edit($id)
  {
    $forecast = Forecast::findOrFail($id);
    $inventory = Inventory::all(); // Fetch all inventory items
    $customers = Customer::all(); // Fetch all customers
    return view('forecast.edit', compact('forecast', 'inventory', 'customers'));
  }

  public function update(Request $request, $id)
  {
    $validatedData = $request->validate([
      'inventory_id' => 'required|string|max:255',
      'part_name' => 'required|string|max:255',
      'part_number' => 'required|string|max:255',
      'customer' => 'required|string|max:255',
      'forecast_qty' => 'required|integer',
      'min_stok' => 'required|integer',
      'max_stok' => 'required|integer',
      'forecast_date' => 'required|date',
    ]);

    $forecast = Forecast::findOrFail($id);
    $forecast->update($validatedData);

    return redirect()->route('forecast.index')->with('success', 'Forecast updated successfully.');
  }

  public function destroy($id)
  {
    $forecast = Forecast::findOrFail($id);
    $forecast->delete();

    return redirect()->route('forecast.index')->with('success', 'Forecast deleted successfully.');
  }

  public function import(Request $request)
  {
    $request->validate([
      'file' => 'required|mimes:xls,xlsx'
    ]);

    try {
      Excel::import(new ForecastImport, $request->file('file'));
      return redirect()->route('forecast.index')->with('success', 'Forecast imported successfully.');
    } catch (\Exception $e) {
      return redirect()->route('forecast.index')->with('error', 'Error importing forecast: ' . $e->getMessage());
    }
  }

  public function importSummary(Request $request,  ForecastSummaryImportService $importService)
  {
    $request->validate([
      'file' => 'required|mimes:xls,xlsx'
    ]);

    try {
      $filePath = $request->file('file')->store('temp'); // Store temporarily
      $data = $importService->import(storage_path("app/{$filePath}"));
      dd($data);
      // Save to database
      foreach ($data as $row) {
        ForecastSummary::create($row);
      }

      return redirect()->route('forecast.index')->with('success', 'Forecast imported successfully.');
    } catch (\Exception $e) {
      return redirect()->route('forecast.index')->with('error', 'Error importing forecast: ' . $e->getMessage());
    }
  }

  public function fetchForecastData(Request $request)
  {
    $month = $request->input('month');
    $customer = $request->input('customer');

    $forecasts = Forecast::whereYear('forecast_date', '=', date('Y', strtotime($month)))
      ->whereMonth('forecast_date', '=', date('m', strtotime($month)))
      ->where('customer', '=', $customer)
      ->orderBy('forecast_date', 'desc')
      ->take(3)
      ->get(['part_name', 'forecast_qty', 'forecast_date']);

    return response()->json($forecasts);
  }

  public function fetchReportSTO(Request $request)
  {
    $month = $request->input('month');
    $customer = $request->input('customer');

    if ($customer) {
      // Fetch data for the specific customer
      $data = Inventory::where('customer', $customer)
        ->whereMonth('date', $month)
        ->get();
    } else {
      // Fetch aggregated data for all customers
      $data = Inventory::whereMonth('date', $month)
        ->get();
    }

    return response()->json($data);
  }
}
