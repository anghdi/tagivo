<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index');
Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoices.store');
Route::get('/invoice/{slug}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::get('/invoice/{slug}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');

// Admin Auth
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->middleware('throttle:5,1');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

use App\Http\Middleware\AdminAuthMiddleware;

// Secure Admin Dashboard
Route::middleware(AdminAuthMiddleware::class)->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/invoice/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.invoice.status');
});
