<?php

namespace App\Http\Controllers;

use App\Models\ContasAPagar;
use App\Services\ContasServices;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContasAPagarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ContasAPagar::query();
        if ($request->has('status') && is_array($request->status)) {
            $query->whereIn('status', $request->status);
        }

        // Filtro por data de vencimento
        if ($request->has('data_vencimento_inicio') && $request->data_vencimento_inicio) {
            $query->whereBetween('data_vencimento', [$request->data_vencimento_inicio, $request->data_vencimento_fim]);
        } else {
            $query->whereBetween('data_vencimento', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ]);
        }


        // Filtro por data de pagamento
        if ($request->has('data_pagamento_inicio') && $request->data_pagamento_inicio) {
            $query->whereBetween('data_recebimento', [$request->data_pagamento_inicio, $request->data_pagamento_fim]);
        }

        // Buscando as contas
        $cPagar = $query->OrderByRaw('data_vencimento')->get();

        return view('contaspagar.todos', compact('cPagar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contaspagar.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descricao'       => 'required',
            'valor'           => 'required',
            'data_vencimento' => 'required',
            'status'          => 'required'
        ]);
        $vencimento = $request->data_vencimento;
        if ($request->nParcelas > 1) {
            for ($i = 0; $i < $request->nParcelas; $i++) {
                $venc = ContasServices::proximoMes($vencimento);
                ContasAPagar::create([
                    'fornecedor'      => $request->fornecedor,
                    'descricao'       => $request->descricao,
                    'valor'           => $request->valor,
                    'data_vencimento' => $venc,
                    'data_pagamento'  => $request->data_pagamento,
                    'status'          => $request->status
                ]);
                $vencimento = $venc;
            }
        } else {
            ContasAPagar::create([
                'fornecedor'      => $request->fornecedor,
                'descricao'       => $request->descricao,
                'valor'           => $request->valor,
                'data_vencimento' => $request->data_vencimento,
                'data_pagamento'  => $request->data_pagamento,
                'status'          => $request->status
            ]);
        }
        sweetalert('Contas a pagar salva com sucesso !');
        return Redirect()->route('contasPagar.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContasAPagar $contasAPagar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($contasAPagar)
    {
        $conta = ContasAPagar::find($contasAPagar);

        return view('contaspagar.new', ['conta' => $conta]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $contasAPagar)
    {
        $conta = ContasAPagar::find($contasAPagar);
        $conta->update([
            'fornecedor'      => $request->fornecedor,
            'descricao'       => $request->descricao,
            'valor'           => $request->valor,
            'data_vencimento' => $request->data_vencimento,
            'data_pagamento'  => $request->data_pagamento,
            'status'          => $request->status
        ]);
        sweetalert('Contas a pagar salva com sucesso !');
        return Redirect()->route('contasPagar.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $conta = ContasAPagar::find($request->idContaM);
        $conta->delete();
        sweetalert('Deletado com sucesso !');
        return redirect()->route('contasPagar.index');
    }

    public function contasPagarPagas(Request $request)
    {
        $query = ContasAPagar::where('status', 'pago');

        if ($request->filled('mes')) {
            $mes = $request->mes;
            $query->whereMonth('data_pagamento', $mes);
        } else {
            $query->whereBetween('data_pagamento', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ]);
        }

        $cPagar = $query->orderByDesc('data_pagamento')->get();

        return view('contaspagar.pagas', compact('cPagar'));
    }

    public function contasPendentes()
    {
        $contas = ContasAPagar::where('status', 'pendente')
            ->whereBetween('data_vencimento', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->orderByDesc('data_vencimento')
            ->get();

        return view('contaspagar.pendentes', compact('contas'));
    }

    public function contasAtrasadas()
    {
        $contas = ContasAPagar::where('status', 'atrasado')
            ->where('data_vencimento', '<', Carbon::now())
            ->orderByDesc('data_vencimento')
            ->get();

        return view('contaspagar.atrasadas', compact('contas'));
    }

    public function pagar(Request $request, $id)
    {
        $request->validate([
            'data_pagamento' => 'required|date',
            'valor' => 'required|numeric'
        ]);
    
        $conta = ContasAPagar::findOrFail($id);
        $conta->update([
            'data_pagamento' => $request->data_pagamento,
            'valor' => $request->valor,
            'status' => 'pago'
        ]);
    
        sweetalert('Pagamento registrado com sucesso!');
        return redirect()->back();
    }
}

    /**
     * Marca a conta como paga, atualizando status, data_pagamento e valor.
     */
