<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ContasAPagar;
use App\Models\ContasAReceber;
use Carbon\Carbon;
use Database\Seeders\ContasReceber;
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
        // Atualiza o status das contas
        $this->atualizarStatusContas();
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        // Conta o número total de clientes
        $clientes = Cliente::count();

        // Define as datas de início e fim para um intervalo de 12 meses
        $dtEnd = Carbon::now();
        $dtBegin = $dtEnd->copy()->subMonths(12)->startOfMonth();
        $dtEnd = $dtEnd->endOfMonth();

        // Converte as datas para o formato de string 'YYYY-MM-DD'
        $startDate = $dtBegin->toDateString();
        $endDate = $dtEnd->toDateString();

        // Consulta de recebimentos para o gráfico de recebimentos por mês
        $recebimentos = ContasAReceber::selectRaw('DATE_FORMAT(data_recebimento, "%m/%Y") as mes_ano, sum(valor) as valortotal')
            ->whereNotNull('data_recebimento')
            ->whereBetween('data_recebimento', [$startDate, $endDate])
            ->groupByRaw('DATE_FORMAT(data_recebimento, "%m/%Y")')
            ->get();

        // Consulta para a tabela de contas atrasadas
        $contasAtrasadas = ContasAReceber::where('status', 'atrasado')
            ->join('clientes', 'contas_a_recebers.cliente_id', '=', 'clientes.id')
            ->select(
                'clientes.nome_fantasia as cliente_nome',
                'contas_a_recebers.valor',
                'contas_a_recebers.data_vencimento'
            )
            ->get()
            ->map(function ($conta) {
                $dataVencimento = Carbon::parse($conta->data_vencimento);
                $dataAtual = Carbon::now();

                // Calcula a diferença detalhada entre as datas
                $diferenca = $dataVencimento->diff($dataAtual);

                $mesesAtraso = $diferenca->m;
                $diasAtraso = $diferenca->d;

                // Formatação condicional para o tempo de atraso
                if ($mesesAtraso > 0 && $diasAtraso > 0) {
                    $conta->tempo_atraso = "{$mesesAtraso} meses {$diasAtraso} dias";
                } elseif ($mesesAtraso > 0) {
                    $conta->tempo_atraso = "{$mesesAtraso} meses";
                } else {
                    $conta->tempo_atraso = "{$diasAtraso} dias";
                }

                return $conta;
            });

        // Calcula o total de valores atrasados
        $atrasados = ContasAReceber::where('status', 'atrasado')->sum('valor');

        // Calcula a inadimplência
        $inadiplencia = round($this->calcularInadimplencia(), 2);

        // Calcula o montante total a receber
        $totalAmount = ContasAReceber::whereBetween('data_vencimento', [$currentMonthStart, $currentMonthEnd])
            ->sum('valor');

        // Calcula o valor já recebido
        $receivedAmount = ContasAReceber::whereBetween('data_vencimento', [$currentMonthStart, $currentMonthEnd])->where('status', 'recebido')->sum('valor');

        // Calcula o valor que falta receber
        $remainingAmount = max(0, $totalAmount - $receivedAmount);
        // dd($remainingAmount);

        // Prepara os dados para o gráfico de recebimentos por mês
        $labels = $recebimentos->pluck('mes_ano')->toArray();
        $data = $recebimentos->pluck('valortotal')->toArray();




        $contasApagar = ContasAPagar::whereBetween('data_vencimento', [$currentMonthStart, $currentMonthEnd])->sum('valor');

        $contasAreceber = ContasAReceber::whereBetween('data_vencimento', [$currentMonthStart, $currentMonthEnd])->sum('valor');

        $pendente = ContasAReceber::where('status', 'pendente')
            ->where('data_vencimento', '<=', $currentMonthEnd)
            ->sum('valor');


        $groupedByDueDate = ContasAReceber::selectRaw('data_vencimento, SUM(valor) as total_valor')
            ->whereBetween('data_vencimento', [now()->startOfMonth(), now()->endOfMonth()])
            ->groupBy('data_vencimento')
            ->get()
            ->map(function ($item) {
                $item->data_vencimento = \Carbon\Carbon::parse($item->data_vencimento)->format('Y-m-d');
                return $item;
            });

        $groupedByReceivedDate = ContasAReceber::selectRaw('DATE(data_recebimento) as data_recebimento, SUM(valor) as total_valor')
            ->whereMonth('data_recebimento', '=', date('m'))
            ->groupBy('data_recebimento')
            ->get();

        // Retorna a view 'home' com os dados necessários
        return view('home', [
            'clientes' => $clientes,
            'tt_atradado' => $atrasados,
            'inadiplencia' => $inadiplencia,
            'recebimentosLabels' => $labels,
            'recebimentosData' => $data,
            'contasAtrasadas' => $contasAtrasadas,
            'totalAmount' => $totalAmount,
            'receivedAmount' => $receivedAmount,
            'remainingAmount' => $remainingAmount,
            'apagar' => $contasApagar,
            'areceber' => $contasAreceber,
            'pendente' => $pendente,
            'groupedByDueDate' => $groupedByDueDate,
            'groupedByReceivedDate' => $groupedByReceivedDate,

        ]);
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


        $contasAtualizadas = ContasAReceber::where('data_vencimento', '<', $hoje)
            ->where('status', 'pendente')
            ->update(['status' => 'atrasado']);


        $contasApagarAtualizadas = ContasAPagar::where('data_vencimento', '<', $hoje)
            ->where('status', 'pendente')
            ->update(['status' => 'atrasado']);

        // return response()->json([
        //     'message' => 'Status atualizado com sucesso.',
        //     'contasAtualizadas' => count($contasAtualizadas)
        // ]);
    }
}
