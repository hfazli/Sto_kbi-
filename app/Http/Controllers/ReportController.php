<?php

namespace App\Http\Controllers;

use App\Models\ReportSTO;
use App\Models\Inventory;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ReportController extends Controller
{
  public function index()
  {
    // Fetch reports from the database
    $reports = ReportSTO::with(['inventory',  'preparer'])->get();

    // Pass the reports to the view
    return view('reports.index', compact('reports'));
  }

  public function show($id)
  {
    $report = ReportSTO::with(['inventory', 'preparer'])->findOrFail($id);

    // Pass the report to the view
    return view('reports.show', compact('report'));
  }

  public function print($id)
  {
    $report = ReportSTO::with(['inventory', 'preparer'])->findOrFail($id);

    $renderer = new ImageRenderer(
      new RendererStyle(200),
      new SvgImageBackEnd()
    );
    $writer = new Writer($renderer);
    $qrCodeSvg = $writer->writeString($report->inventory_id ?? '-');

    // Convert SVG to Base64
    $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

    // Load Blade view with QR Code
    $html = View::make('reports.pdf', compact('report', 'qrCodeBase64'))->render();

    // PDF Options
    $options = new Options();
    $options->set('defaultFont', 'Helvetica');
    $options->set('isHtml5ParserEnabled', true);

    // Generate PDF
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->render();

    // Stream PDF to Browser
    return $dompdf->stream("report-sto-" . $report->inventory_id . ".pdf");
  }

  public function delete($id)
  {
    $report = ReportSTO::findOrFail($id);
    $report->delete();

    // Redirect back with success message
    return redirect()->route('reports.index')->with('success', 'Report Berhasil Dihapus');
  }

  public function update(Request $request, $id)
  {
    $validatedData = $request->validate([
      'inventory_id' => 'required|exists:inventory,inventory_id',
      'issued_date' => 'required|date',
      'prepared_by' => 'required|string',
      'status' => 'required|string',
      'qty_per_box' => 'required|integer',
      'qty_box' => 'required|integer',
      'total' => 'required|integer',
      'qty_per_box_2' => 'nullable|integer',
      'qty_box_2' => 'nullable|integer',
      'total_2' => 'nullable|integer',
      'grand_total' => 'required|integer',
      'detail_lokasi' => 'nullable|string',
      'customer' => 'nullable|string',
    ]);

    $reportSTO = ReportSTO::findOrFail($id);
    $reportSTO->update($validatedData);

    // Redirect back with success message
    return redirect()->route('reports.index')->with('success', "Report STO with Inventory ID {$reportSTO->inventory_id} updated successfully.");
  }

  public function fetchReportSTO(Request $request)
  {
    $month = $request->input('month');
    $customer = $request->input('customer');

    // Fetch data based on month and customer
    $data = Inventory::where('month', $month)
      ->where('customer', $customer)
      ->get(['part_name', 'total']);

    // Pass the data to the view
    return view('reports.fetch', compact('data'));
  }
}
