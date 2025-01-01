<?php

use App\Models\ContasAReceber;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $hoje = date('Y-m-d');

    $contas = ContasAReceber::where('data_vencimento', '<', $hoje)
        ->where('status', '=', 'pendente')
        ->get();

    foreach ($contas as $conta) {
        $conta->status = 'atrasado';
        $conta->save();
    }
})->daily();
