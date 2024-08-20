<?php

namespace App\Console\Commands;

use App\Models\ContasAReceber;
use Carbon\Carbon;
use Illuminate\Console\Command;

class atualizarStatusConta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:atualizar-status-conta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza o vencimento das contas a receber automaticamente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoje = Carbon::now();

        // Seleciona contas não atrasadas com data de vencimento anterior a hoje
        $contas = ContasAReceber::where('data_vencimento', '<', $hoje)
            ->where('status', '=', 'pendente')
            ->get();

        // Atualiza o status para 'atrasado'
        foreach ($contas as $conta) {
            $conta->status = 'atrasado';
            $conta->save();
        }

        // Retorna resposta de sucesso com o número de contas atualizadas
        return response()->json([
            'message' => 'Status atualizado com sucesso.',
            'contasAtualizadas' => count($contas)
        ]);
    }
}
