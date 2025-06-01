<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContasAPagarController;
use App\Http\Controllers\ContasAReceberController;
use App\Http\Controllers\FluxoDeCaixaController;
use App\Http\Controllers\PaymentController;
use App\Models\ContasAReceber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    // Rotas de Clientes
    Route::resource('clientes', ClienteController::class);
    Route::delete('/cliente/del', [ClienteController::class, 'destroy'])->name('delete-cliente');

    // Rotas de Contas a Receber
    Route::resource('contasReceber', ContasAReceberController::class);
    Route::delete('/contasReceber/del', [ContasAReceberController::class, 'destroy'])->name('delete-receber');
    Route::get('/contas/pagas', [ContasAReceberController::class, 'contasPagas'])->name('contas-receber.pagas');
    Route::get('/contas/pendentes', [ContasAReceberController::class, 'contasPendentes'])->name('contas.pendentes');
    Route::get('/contas/atrasadas', [ContasAReceberController::class, 'contasAtrasadas'])->name('contas.atrasadas');

    // Rotas de Contas a Pagar
    Route::resource('contasPagar', ContasAPagarController::class);
    Route::delete('/contasPagar/del', [ContasAPagarController::class, 'destroy'])->name('delete-contasPagar');
    Route::get('/contasAPagar/pagas', [ContasAPagarController::class, 'contasPagarPagas'])->name('contasApagar.pagas');
    Route::get('/contasAPagar/pendentes', [ContasAPagarController::class, 'contasPendentes'])->name('contas-pagar.pendentes');
    Route::get('/contasAPagar/atrasadas', [ContasAPagarController::class, 'contasAtrasadas'])->name('contas-pagar.atrasadas');
    Route::put('/contasPagar/{id}/pagar', [ContasAPagarController::class, 'pagar'])->name('contasApagar.pagar');

    // Rotas de Fluxo de Caixa
    Route::resource('caixa', FluxoDeCaixaController::class);
    Route::delete('/caixa/del', [FluxoDeCaixaController::class, 'destroy'])->name('delete-lancamento');

    // Rotas de Pagamentos
    Route::get('/pagamentos', [PaymentController::class, 'index'])->name('pagamentos.index');
    Route::post('/pagamentos-receber', [PaymentController::class, 'store'])->name('pagamentos.store');
});
