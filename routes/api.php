<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CallbackController;

Route::get('/', [ApiController::class, 'index'])->name('api.index');

Route::any('/callback/mercadopago', [CallbackController::class, 'mercadopago']);

Route::post('/authenticate', [AuthController::class, 'authenticate']);

Route::post('/contracts', [ContractController::class, 'fetch']);

Route::post('/billings/open', [BillingController::class, 'open']);

Route::post('/billings/pending', [BillingController::class, 'pending']);

Route::post('/billings/payed', [BillingController::class, 'payed']);

Route::get('/customers/{id}', [CustomerController::class, 'fetch']);

Route::post('/payment', [PaymentController::class, 'post']);
