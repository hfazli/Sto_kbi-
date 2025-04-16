<?php

namespace App\Http\Controllers;

use App\Models\Forecast;
use App\Models\Inventory; // Import the Inventory model
use App\Models\Customer; // Import the Customer model
use Illuminate\Http\Request;
use App\Imports\ForecastImport; // Import the ForecastImport class
use App\Imports\ForecastSummaryImport;
use App\Models\ReportSTO;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel; // Import the Excel facade

class ForecastController extends Controller
{
    public function index()
    {
        $reports = ReportSTO::with('user')->get();
        return view('Reports.daily-index', compact('reports'));
    }

    public function _index(Request $request)
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
            'forecast_day' => 'required|numeric',
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
            'forecast_day' => 'required|numeric',
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

    public function importSummary(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            Excel::import(new ForecastSummaryImport, $request->file('file'));
            return redirect()->route('forecast.index')->with('success', 'Forecast imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('forecast.index')->with('error', 'Error importing forecast: ' . $e->getMessage());
        }
    }

    public function fetchForecastData(Request $request)
    {
        $date = $request->input('date');
        $customer = $request->input('customer');

        $inventoryQuery = ReportSTO::select(
            'part_name',
            DB::raw('SUM(total) as total_grand_total'),
            DB::raw('COUNT(*) as total_records')
        )->groupBy('part_name');

        if ($date) {
            $inventoryQuery->whereDate('issued_date', $date);
        }

        if ($customer) {
            $inventoryQuery->where('customer', $customer);
        }

        $inventory = $inventoryQuery->get();

        return response()->json($inventory);
    }

    // public function fetchForecastData(Request $request)
    // {
    //     $date = $request->input('date');
    //     $customer = $request->input('customer');

    //     $forecasts = Forecast::selectRaw("
    //     customer,
    //     forecast_date,
    //     CASE
    //         WHEN forecast_day > 3 THEN '>3'
    //         ELSE forecast_day
    //     END as forecast_day,
    //     SUM(forecast_qty) as total_forecast_qty
    // ")
    //         ->where('forecast_date', $date)
    //         ->where('customer', $customer)
    //         ->groupBy('forecast_day', 'customer', 'forecast_date')
    //         ->get();

    //     return response()->json($forecasts);
    // }

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
