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

Route::post('/payment', [PaymentController::class, 'post']);

Route::any('/callback/mercadopago', [CallbackController::class, 'mercadopago']);


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ()
{
    Route::post('login', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::post('me', [AuthController::class, 'me']);
});


Route::group(['middleware' => 'api'], function ()
{
    Route::get('/contracts', [ContractController::class, 'fetch']);

    Route::get('/billings/open', [BillingController::class, 'open']);

    Route::get('/billings/pending', [BillingController::class, 'pending']);

    Route::get('/billings/payed', [BillingController::class, 'payed']);

    Route::get('/customer', [CustomerController::class, 'fetch']);
});


