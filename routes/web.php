<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\FlatsellController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ChartController;
use Laravel\Fortify\Fortify;


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

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Fortify::registerView('/register', 'auth.register');

 Route::post('/register', [RegisteredUserController::class, 'register'])->name('register');

// Handle login
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/addsell', [HomeController::class, 'addsell'])->name('admin.addsell');

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});


Route::delete('/vouchers/{id}', [VoucherController::class, 'destroy'])->name('delete.voucher');


Route::get('/accounts', [HomeController::class, 'addsell'])->name('admin.accounts');


Route::post('/save-vouchers', [HomeController::class, 'saveVouchers'])->name('save.vouchers');

Route::get('/accounts', [HomeController::class, 'showVouchers'])->name('admin.accounts');
Route::get('/get-chart-data', [HomeController::class, 'getChartData']);

Route::get('/item-search', [VoucherController::class,'itemSearch'])->name('itemSearch');


Route::get('/export/pdf/{id}', [VoucherController::class, 'generatePDF'])->name('export.pdf');

Route::post('/search-vouchers', [HomeController::class, 'searchVouchers'])->name('search.vouchers');

Route::get('/voucher', [VoucherController::class, 'index'])->name('admin.voucher.index');

Route::post('/search-wizard', [VoucherController::class, 'searchWizard'])->name('search.wizard');

Route::get('/export-multiple-pdf', [VoucherController::class, 'exportMultiplePdf'])->name('export.multiple.pdf');

Route::get('/export-print-pdf', [VoucherController::class, 'saveAndPrint'])->name('print.vouchers');

//company
Route::get('company',[CompanyController::class,'index'])->name('admin.company');

Route::post('/company', [CompanyController::class, 'store'])->name('company.store');
// routes/web.php

Route::get('/calculate-profit', [HomeController::class, 'calculateProfit']);

Route::get('/chart', [ChartController::class, 'index']);
Route::get('/get-flat-voucher-chart', [ChartController::class, 'getFlatVoucherChart']);

// routes/web.php
//Customer
Route::get('customer',[CustomerController::class,'index'])->name('admin.customer');
 Route::post('/customer',[CustomerController::class,'store'])->name('customer.store');

 Route::get('/getFlatsByProject/{project_id}', [CustomerController::class, 'getProjectFlats'])->name('getFlatsByProjectAjax');

// routes/web.php
Route::get('/customers/{id}/edit', [CustomerController::class,'edit'])->name('customers.edit');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customer.update');


Route::get('/get-customer-details/{id}', [CustomerController::class, 'getDetails'])->name('get-customer-details');
//ajax


Route::get('/generate-pdf/{customerId}', [CustomerController::class, 'customergeneratePdf'])->name('generate.pdf');

// routes/web.php

//Item
Route::get('item',[ItemController::class,'index'])->name('admin.item');
Route::post('/store-item', [ItemController::class, 'storeItem'])->name('projects.storeItem');


//Project
Route::get('/projects',  [ProjectController::class, 'index'])->name('admin.project');
Route::post('/projects', [ProjectController::class, 'storeProject'])->name('projects.storeProject');
  Route::get('/show-data', [ProjectController::class, 'showData'])->name('show.data');


  //flats
  Route::get('/flatsell',  [FlatsellController::class, 'index'])->name('admin.flatsell');

  Route::post('/flatsell', [FlatsellController::class, 'store'])->name('flat.voucher');

  Route::post('/generate-invoice', [FlatsellController::class, 'generateInvoice'])->name('generate.invoice');

  Route::get('/flat-export-pdf/{customerId}', [FlatsellController::class, 'exportPdf'])->name('export.pdf');


  Route::delete('/flat-sell/{id}', [FlatsellController::class, 'destroy'])->name('flat-sell.destroy');


  // routes/web.php
  Route::get('/flatselledit/{id}', [FlatsellController::class, 'edit'])->name('admin.flatselledit.edit');
  Route::put('/flatselledit/{id}', [FlatsellController::class, 'update'])->name('admin.flatselledit.update');

 // Correct Livewire route usage


//ajax

Route::get('/getFlatsByCustomer/{customer_id}', [FlatsellController::class, 'getFlatsByCustomerAjax'])->name('getFlatsByCustomerAjax');


   // web.php
Route::get('/getProjectFlats/{projectId}', [CustomerController::class, 'showprojectflats'])->name('getProjectFlats');

// Refund

Route::get('/bankbook',  [BankController::class, 'index'])->name('admin.bankbook');
Route::post('/banks', [BankController::class, 'store'])->name('banks.store');

Route::post('/generate-pdf', [BankController::class, 'generatePdf'])->name('generatePdf');


Route::post('/fullDetails', [VoucherController::class, 'fullDetails'])->name('fullDetails');

//



