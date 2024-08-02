<?php

use App\Http\Controllers\AccessControlController;
use Illuminate\Support\Facades\Route;

Route::get('/customer/{clientId}', [AccessControlController::class, 'getSignatureStatus']);
