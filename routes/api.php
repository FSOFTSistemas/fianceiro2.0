<?php

use App\Http\Controllers\Api\AccessControlController;
use Illuminate\Support\Facades\Route;

Route::get('/customer/{customer_cnpj_cpf}', [AccessControlController::class, 'getSignatureStatus'])
    ->where('customer_cnpj_cpf', '^[0-9\.\-\/]+$');
Route::get('/customer/{customer_cnpj_cpf}/payment-history', [AccessControlController::class, 'getPaymentHistory'])
    ->where('customer_cnpj_cpf', '^[0-9\.\-\/]+$');
