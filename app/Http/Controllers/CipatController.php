<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cipat;
use App\Imports\CipatImport;
use Maatwebsite\Excel\Facades\Excel;

class CipatController extends Controller
{
    public function index()
    {
        $componentParts = Cipat::paginate(10); // Ambil data dengan paginasi
        return view('cipat.index', compact('componentParts'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new CipatImport, $request->file('file'));

        return redirect()->route('cipat.index')->with('success', 'Component Parts imported successfully.');
    }

    // Metode lainnya (create, store, show, edit, update, destroy)
}