<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index');
Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoices.store');
Route::get('/invoice/{slug}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::get('/invoice/{slug}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
