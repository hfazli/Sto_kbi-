<?php
// filepath: /d:/STO-master/STO-master/app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Customer;
use App\Models\ForecastSummary;
use App\Models\Invoice;
use App\Models\ReportSTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function index(Request $request)
  {
    // $month = $request->input('month', now()->month);
    // $year = $request->input('year', now()->year);

    // // Fetch customers from the database
    $customers = Customer::all();
    // $invoices = Invoice::all();

    // // Fetch the data from the database
    // $parts = Part::all();

    // // Prepare the data for the chart
    // $partNames = $parts->pluck('part_name');
    // $partData = $parts->pluck('qty_package'); // Replace 'qty_package' with the actual field name if different
    // $minValues = $parts->pluck('min_value'); // Assuming you have min_value field
    // $maxValues = $parts->pluck('max_value'); // Assuming you have max_value field

    // // Fetch days data
    // $days = Part::select(DB::raw('DAY(created_at) as day'))->distinct()->pluck('day');

    // UPDATE HERE
    $minDate = ReportSTO::min('issued_date'); // Earliest month
    $maxDate = ReportSTO::max('issued_date'); // Latest month

    if (!$minDate || !$maxDate) {
      $months = [];
    } else {
      // Convert to Carbon instances
      $start = Carbon::parse($minDate)->startOfMonth();
      $end = Carbon::parse($maxDate)->startOfMonth();

      // Generate the list of months
      $months = [];
      while ($start->lte($end)) {
        $months[] = $start->copy();
        $start->addMonth();
      }
    }

    $minForecast = ForecastSummary::min('date');
    $maxForecast = ForecastSummary::max('date');

    if (!$minForecast || !$maxForecast) {
      $dates = [];
    } else {
      // Convert to Carbon instances
      $start = Carbon::parse($minForecast);
      $end = Carbon::parse($maxForecast);

      // Generate the list of dates
      $dates = [];
      while ($start->lte($end)) {
        $dates[] = $start->copy(); // Ensure string format (YYYY-MM-DD)
        $start->addDay();
      }
    }

    // return view('dashboard', [
    //   'customers' => $customers,
    //   'partNames' => $partNames,
    //   'partData' => $partData,
    //   'minValues' => $minValues,
    //   'maxValues' => $maxValues,
    //   'days' => $days,
    //   'month' => $month,
    //   'year' => $year,
    //   'invoices' => $invoices,
    // ]);
    return view('dashboard', compact(
      'customers',
      'months',
      'dates',
    ));
  }

  public function reportSto(Request $request)
  {
    $selectedMonth = $request->query('month'); // Example: "2024-02"
    $selectedCust = $request->query('customer');

    // Convert to the first day of the selected month
    $startDate = Carbon::parse($selectedMonth)->startOfMonth();
    $endDate = Carbon::parse($selectedMonth)->endOfMonth();

    // Fetch grouped data
    if (isset($selectedCust)) {
      $data = ReportSTO::whereBetween('issued_date', [$startDate, $endDate])
        ->whereHas('inventory', function ($query) use ($selectedCust) {
          $query->where('customer', $selectedCust);
        })
        ->groupBy('inventory_id')
        ->selectRaw('inventory_id, SUM(grand_total) as total')
        ->with('inventory')
        ->get();
    } else {
      $data = ReportSTO::whereBetween('issued_date', [$startDate, $endDate])
        ->join('inventory', 'report_sto.inventory_id', '=', 'inventory.inventory_id') // Join with inventory table
        ->groupBy('inventory.customer') // Group by customer column
        ->selectRaw('inventory.customer, SUM(report_sto.grand_total) as total') // Select customer and sum of grand_total
        ->with('inventory')
        ->get();
    }
    return response()->json($data);
  }

  public function forecastSummary(Request $request)
  {
    $date = $request->query('date');
    $customer = $request->query('customer');

    $data = ForecastSummary::where('customer_name', $customer)
      ->whereDate('date', $date)
      ->selectRaw('customer_name, stock_day, SUM(stock_value) as stock_value')
      ->groupBy('customer_name', 'stock_day')
      ->get();

    return response()->json($data);
  }
}
