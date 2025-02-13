<?php

namespace App\Http\Controllers;

use App\Models\Wip;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WipImport;

class WipController extends Controller
{
    public function index()
    {
        $wips = Wip::paginate(10);
        return view('wip.index', compact('wips'));
    }

    public function create()
    {
        return view('wip.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required',
            'part_name' => 'required',
            'part_number' => 'required',
            'type_package' => 'required',
            'qty_per_package' => 'required',
            'project' => 'required',
            'customer' => 'required',
            'location_rak' => 'required',
        ]);

        Wip::create($request->all());

        return redirect()->route('wip.index')->with('success', 'WIP created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Wip $wip)
    {
        return view('wip.edit', compact('wip'));
    }

    public function update(Request $request, Wip $wip)
    {
        $request->validate([
            'inventory_id' => 'required',
            'part_name' => 'required',
            'part_number' => 'required',
            'type_package' => 'required',
            'qty_per_package' => 'required',
            'project' => 'required',
            'customer' => 'required',
            'location_rak' => 'required',
        ]);

        $wip->update($request->all());

        return redirect()->route('wip.index')->with('success', 'WIP updated successfully.');
    }

    public function destroy(Wip $wip)
    {
        $wip->delete();

        return redirect()->route('wip.index')->with('success', 'WIP deleted successfully.');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new WipImport, $request->file('file'));

        return redirect()->route('wip.index')->with('success', 'WIP imported successfully.');
    }
}
