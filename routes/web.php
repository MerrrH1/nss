<?php

use App\Http\Controllers\BuyerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseContractController;
use App\Http\Controllers\SalesContractController;
use App\Http\Controllers\SalesDeliveriesController;
use App\Http\Controllers\SalesInvoiceController;
use App\Http\Controllers\SalesTaxInvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
Route::get('/buyers', [BuyerController::class, 'index'])->name('buyers.index');
Route::resource('/sales_contracts', SalesContractController::class);
Route::get('close_sales_contracts/{salesContract}', [SalesContractController::class, 'closeContract'])->name('sales_contract.closeContract');
Route::resource('/sales_deliveries', SalesDeliveriesController::class);
Route::get('/create_sales_deliveries/{salesContract}', [SalesDeliveriesController::class, 'createSalesDelivery'])->name('sales_deliveries.createSalesDelivery');
Route::get('/unload_sales_deliveries/{salesDelivery}', [SalesDeliveriesController::class, 'unload'])->name('sales_deliveries.unload');
Route::get('/reject_sales_deliveries/{salesDelivery}', [SalesDeliveriesController::class, 'cancel'])->name('sales_deliveries.cancel');
Route::resource('/sales_invoices', SalesInvoiceController::class);
Route::get('/create_sales_invoice/{salesContract}', [SalesInvoiceController::class, 'createSalesInvoice'])->name('sales_invoices.create');
Route::resource('/sales_tax_invoices', SalesTaxInvoiceController::class);
Route::resource('/purchase_contracts', PurchaseContractController::class);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';