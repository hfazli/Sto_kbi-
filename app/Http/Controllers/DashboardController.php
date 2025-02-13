<?php
// filepath: /d:/STO-master/STO-master/app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Fetch customers from the database
        $customers = Customer::all();

        // Fetch the data from the database
        $parts = Part::all();

        // Prepare the data for the chart
        $partNames = $parts->pluck('part_name');
        $partData = $parts->pluck('qty_package'); // Replace 'qty_package' with the actual field name if different
        $minValues = $parts->pluck('min_value'); // Assuming you have min_value field
        $maxValues = $parts->pluck('max_value'); // Assuming you have max_value field

        // Fetch days data
        $days = Part::select(DB::raw('DAY(created_at) as day'))->distinct()->pluck('day');

        return view('dashboard', [
            'customers' => $customers,
            'partNames' => $partNames,
            'partData' => $partData,
            'minValues' => $minValues,
            'maxValues' => $maxValues,
            'days' => $days,
            'month' => $month,
            'year' => $year,
        ]);
    }
}