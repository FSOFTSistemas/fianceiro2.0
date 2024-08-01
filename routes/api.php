<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

Route::get('/{clientId}/cliente', [ClienteController::class, 'getSignatureStatus']);
