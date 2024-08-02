<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContasAPagarController;
use App\Http\Controllers\ContasAReceberController;
use App\Http\Controllers\FluxoDeCaixaController;
use App\Models\ContasAPagar;
use App\Models\ContasAReceber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('clientes', ClienteController::class)->middleware('auth');
Route::delete('/cliente/del', [ClienteController::class, 'destroy'])->name('delete-cliente')->middleware('auth');
Route::resource('contasReceber', ContasAReceberController::class)->middleware('auth');
Route::delete('/contasReceber/del', [ContasAReceberController::class, 'destroy'])->name('delete-receber')->middleware('auth');
Route::resource('contasPagar', ContasAPagarController::class)->middleware('auth');
Route::delete('/contasPagar/del', [ContasAPagarController::class, 'destroy'])->name('delete-contasPagar')->middleware('auth');
Route::resource('caixa', FluxoDeCaixaController::class)->middleware('auth');
Route::delete('/caixa/del', [FluxoDeCaixaController::class, 'destroy'])->name('delete-lancamento')->middleware('auth');
Route::get('/pagamento',[ContasAReceberController::class, 'informarPagamento'])->name('pagamento')->middleware('auth');
Route::get('/receber-cliente/{id}',[ContasAReceberController::class, 'contasCliente'])->name('contas-clientes')->middleware('auth');



