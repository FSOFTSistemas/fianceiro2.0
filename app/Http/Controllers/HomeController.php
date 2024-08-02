<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ContasAReceber;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $dtEnd = new DateTime();

        // Ajusta a data de início para o primeiro dia do mês 12 meses atrás
        $dtBegin = (clone $dtEnd)->modify('-12 months')->modify('first day of this month');

        // Ajusta a data de término para o último dia do mês atual
        $dtEnd->modify('last day of this month');

        // Formata as datas para o formato Y-m-d
        $startDate = $dtBegin->format('Y-m-d');
        $endDate = $dtEnd->format('Y-m-d');
        $recebimentos = ContasAReceber::select(DB::raw('DATE_FORMAT(data_recebimento, "%m/%Y") as mes_ano'), DB::raw('sum(valor) as valortotal'))->whereNotNull('data_recebimento')->whereBetween('data_recebimento', [$startDate, $endDate])->groupBy(DB::raw('DATE_FORMAT(data_recebimento, "%m/%Y")'))->get();
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
