<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/invoices', [BillingController::class, 'createInvoice']);
Route::post('/subscriptions', [BillingController::class, 'createSubscription']);
Route::post('/payments/{invoiceId}', [BillingController::class, 'processPayment']);
