<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\STOController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('inventory', [InventoryController::class, 'index']);
Route::post('inventory', [InventoryController::class, 'store']);
Route::get('inventory/{id}', [InventoryController::class, 'show']);
Route::put('inventory/{id}', [InventoryController::class, 'update']);
Route::delete('inventory/{id}', [InventoryController::class, 'destroy']);
Route::post('inventory/import', [InventoryController::class, 'import']);
Route::post('inventory/upload', [InventoryController::class, 'upload']);
Route::post('inventory/{id}/change-status', [InventoryController::class, 'changeStatus']);
Route::post('inventory/scan', [InventoryController::class, 'scanInventory']);

Route::get('reports', [ReportController::class, 'index']);
Route::get('reports/{id}', [ReportController::class, 'show']);
Route::put('reports/{id}', [ReportController::class, 'update']);
Route::delete('reports/{id}', [ReportController::class, 'delete']);
Route::post('reports/fetch', [ReportController::class, 'fetchReportSTO']);
Route::get('reports/{id}/print', [ReportController::class, 'print']);

Route::get('sto', [STOController::class, 'index']);
Route::get('sto/{id}', [STOController::class, 'show']);
Route::post('sto/scan', [STOController::class, 'scan']);
Route::post('sto/form/{inventory_id}', [STOController::class, 'form']);
Route::post('sto', [STOController::class, 'store']);
Route::post('sto/new', [STOController::class, 'storeNew']);
Route::post('sto/search', [STOController::class, 'search']);
