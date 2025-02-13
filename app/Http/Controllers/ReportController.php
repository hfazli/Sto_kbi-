<?php
// filepath: /d:/STO-master/STO-master/app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use App\Models\Report; // Import the Report model
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Fetch reports from the database
        $reports = Report::all();

        // Pass the reports to the view
        return view('reports.index', compact('reports'));
    }
}