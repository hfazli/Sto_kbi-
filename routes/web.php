<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FinishedGoodController;
use App\Http\Controllers\WipController;
use App\Http\Controllers\CipatController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FinishedGoodsController;
use App\Http\Controllers\STOController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;

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

Route::resource('finished_goods', FinishedGoodController::class);

Route::get('finished_goods/{finished_good}/edit', [FinishedGoodController::class, 'edit'])->name('finished_goods.edit');
Route::post('finished_goods/import', [FinishedGoodController::class, 'import'])->name('finished_goods.import');
Route::get('finished_goods/upload', [FinishedGoodController::class, 'showUploadForm'])->name('finished_goods.upload');
Route::post('finished_goods/upload', [FinishedGoodController::class, 'upload'])->name('finished_goods.upload');
Route::post('/finished_goods/change_status/{id}', [FinishedGoodController::class, 'changeStatus'])->name('finished_goods.change_status');
Route::post('finished_goods/{id}/change-status', [FinishedGoodController::class, 'changeStatus'])->name('finished_goods.changeStatus');
Route::post('/finished_goods', [FinishedGoodController::class, 'store'])->name('finished_goods.store');
Route::get('/finished_goods', [FinishedGoodController::class, 'index'])->name('finished_goods.index');
Route::post('/finished_goods/{id}/change-status', [FinishedGoodController::class, 'changeStatus'])->name('finished_goods.changeStatus');
Route::get('/finished_goods/downloadPdf', [FinishedGoodController::class, 'downloadPdf'])->name('finished_goods.downloadPdf');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/finished-good', [FinishedGoodController::class, 'finishedGood'])->name('finished.good');

Route::resource('users', UserController::class);
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/{user}/edit-password', [UserController::class, 'editPassword'])->name('users.editPassword');
Route::post('/users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');

Route::resource('wip', WipController::class);
Route::post('wip/upload', [WipController::class, 'upload'])->name('wip.upload');
Route::post('/wip/import', [WipController::class, 'import'])->name('wip.import');

Route::resource('cipat', CipatController::class);
Route::post('cipat/upload', [CipatController::class, 'upload'])->name('cipat.upload');

Route::resource('component_parts', CipatController::class);

Route::get('/reports/fg', [ReportController::class, 'index'])->name('reports.fg');

Route::get('/sto', [STOController::class, 'index'])->name('sto.index');

// Define the inventory store route
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');