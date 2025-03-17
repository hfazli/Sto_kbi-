<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\STOController;
use App\Http\Controllers\InventoryController;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\PriceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return view('login-admin');
})->name('login-admin');

Route::get('/login', function () {
  return redirect()->route('login-admin');
})->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes
Route::prefix('admin')->group(function () {
  Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
  Route::post('login', [AdminAuthController::class, 'login'])->name('postlogin');
  Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::get('/Login-user', function () {
  return view('Login-user');
})->name('Login-user');

Route::post('/login-user', [UserController::class, 'login'])->name('loginUser');

Route::middleware('admin.auth')->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  // Report
  Route::delete('/reports/{id}/destroy', [ReportController::class, 'delete'])->name('reports.destroy');
  Route::get('/reports/fg', [ReportController::class, 'index'])->name('reports.fg');
  Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
  Route::put('/reports/{id}/edit', [ReportController::class, 'update'])->name('reports.update');
  Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
  Route::post('/reports/store', [ReportController::class, 'store'])->name('reports.store');
  Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

  // Inventory
    Route::get('inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
  Route::get('inventory/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
  Route::post('inventory/import', [InventoryController::class, 'import'])->name('inventory.import');
  Route::get('inventory/upload', [InventoryController::class, 'showUploadForm'])->name('inventory.upload');
  Route::post('inventory/upload', [InventoryController::class, 'upload'])->name('inventory.upload');
  Route::post('/inventory/change_status/{id}', [InventoryController::class, 'changeStatus'])->name('inventory.change_status');
  Route::post('inventory/{id}/change-status', [InventoryController::class, 'changeStatus'])->name('inventory.changeStatus');
  Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
  Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
  Route::get('/inventory-data', [InventoryController::class, 'data'])->name('inventory.data');
  Route::post('/inventory/{id}/change-status', [InventoryController::class, 'changeStatus'])->name('inventory.changeStatus');
  Route::get('/inventory/downloadPdf', [InventoryController::class, 'downloadPdf'])->name('inventory.downloadPdf');
  Route::get('/inventory-data', [InventoryController::class, 'data'])->name('inventory.data');
  Route::delete('/inventory/destroy/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
  Route::get('inventory/export', [InventoryController::class, 'export'])->name('inventory.export');
  Route::put('inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update'); // Add this line

  // Forecast
  Route::get('/forecast', [ForecastController::class, 'index'])->name('forecast.index');
  Route::get('/forecast/create', [ForecastController::class, 'create'])->name('forecast.create');
  Route::post('/forecast', [ForecastController::class, 'store'])->name('forecast.store');
  Route::get('/forecast/{id}/edit', [ForecastController::class, 'edit'])->name('forecast.edit');
  Route::put('/forecast/{id}', [ForecastController::class, 'update'])->name('forecast.update');
  Route::delete('/forecast/{id}', [ForecastController::class, 'destroy'])->name('forecast.destroy');
  Route::post('/forecast/import', [ForecastController::class, 'import'])->name('forecast.import');
  Route::post('/forecast/import/summary', [ForecastController::class, 'importSummary'])->name('forecast.summary.import');
  Route::get('/fetch-forecast-data', [ForecastController::class, 'fetchForecastData']);

  // Users
  Route::resource('users', UserController::class);
  Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
  Route::get('/users/{user}/edit-password', [UserController::class, 'editPassword'])->name('users.editPassword');
  Route::post('/users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');

  // Define the price routes
  Route::resource('price', PriceController::class);
  Route::post('price/import', [PriceController::class, 'import'])->name('price.import');
});


Route::middleware('auth')->group(function () {
  Route::get('/sto', [STOController::class, 'index'])->name('sto.index');
  Route::get('/sto/{id}', [STOController::class, 'show'])->name('sto.show');
  Route::post('/sto-scan', [STOController::class, 'scan'])->name('sto.scan');
  Route::get('/sto-form/{inventory}', [STOController::class, 'form'])->name('sto.form');
  Route::post('/sto-form/store/new', [STOController::class, 'storeNew'])->name('sto.storeNew');
  Route::post('/sto-form/{inventory}/store', [STOController::class, 'store'])->name('sto.store');
  Route::get('/scan-sto', [InventoryController::class, 'showForm'])->name('scan-sto');
  Route::get('/sto-search', [STOController::class, 'search'])->name('sto.search');
  Route::get('/sto-edit', [STOController::class, 'edit'])->name('sto.edit');
  Route::put('/sto-form/{inventory}/update', [STOController::class, 'update'])->name('sto.update');
  // Route::get('/sto/print/{inventory_id}', [STOController::class, 'printPDF'])->name('sto.print');
  // Route::get('/sto/print-pdf/{reportId}', [STOController::class, 'printPDF'])->name('sto.printPDF');
});


// FETCH DATA FOR CHARTS
Route::get('/reports/{id}/print', [ReportController::class, 'print'])->name('reports.print');
Route::get('/fetch-report-sto', [DashboardController::class, 'reportSto'])->name('dashboard.sto');
Route::get('/fetch-forecast-summary', [DashboardController::class, 'forecastSummary'])->name('dashboard.forecast');
Route::get('/fetch-forecast-data', [ForecastController::class, 'fetchForecastData']);


Route::get('/form', [STOController::class, 'showForm'])->name('form');

Route::get('reports/export', function () {
  return Excel::download(new ReportsExport, 'reports.xlsx');
})->name('reports.export');
