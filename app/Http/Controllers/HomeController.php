<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ContasAReceber;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->atualizarStatusContas();
        $clientes = Cliente::count();
        $atrasados = ContasAReceber::where('status', 'atrasado')->sum('valor');
        $inadiplencia = $this->calcularInadimplencia();
        return view('home', ['clientes' => $clientes, 'tt_atradado' => $atrasados, 'inadiplencia' => $inadiplencia]);
    }

    public function calcularInadimplencia($ano = null, $mes = null)
    {
        $hoje = Carbon::now();
        $ano = $ano ?? $hoje->year;
        $mes = $mes ?? $hoje->month;

        $inicioMes = Carbon::create($ano, $mes, 1)->startOfMonth();
        $fimMes = Carbon::create($ano, $mes, 1)->endOfMonth();

        $totalMes = ContasAReceber::whereBetween('data_vencimento', [$inicioMes, $fimMes])->sum('valor');
        $totalAtrasados = ContasAReceber::whereBetween('data_vencimento', [$inicioMes, $fimMes])
            ->where('status', 'atrasado')
            ->sum('valor');

        $porcentagemInadimplencia = $totalMes > 0 ? ($totalAtrasados / $totalMes) * 100 : 0;

        return $porcentagemInadimplencia;
    }

    public function atualizarStatusContas()
    {
        $hoje = Carbon::now();

        // Seleciona contas não atrasadas com data de vencimento anterior a hoje
        $contas = ContasAReceber::where('data_vencimento', '<', $hoje)
            ->where('status', '!=', 'atrasado')
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
