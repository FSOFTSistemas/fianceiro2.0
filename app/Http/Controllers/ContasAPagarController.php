<?php

namespace App\Http\Controllers;

use App\Models\ContasAPagar;
use ContasServices;
use Illuminate\Http\Request;

class ContasAPagarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contas = ContasAPagar::all();
        return view('contaspagar.todos', ['cPagar' => $contas]);
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
        try {
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


            return Redirect()->route('contasPagar.index')->with('success', 'Contas a pagar salva com sucesso !');
        } catch (\Exception $e) {
            return Redirect()->back()->with('ERRO AO INSERIR CONTA: ' . $e->getMessage())->withInput();
        }
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
        try {
            $conta = ContasAPagar::find($contasAPagar);

            $conta->update([
                'fornecedor'      => $request->fornecedor,
                'descricao'       => $request->descricao,
                'valor'           => $request->valor,
                'data_vencimento' => $request->data_vencimento,
                'data_pagamento'  => $request->data_pagamento,
                'status'          => $request->status
            ]);

         return Redirect()->route('contasPagar.index')->with('success', 'Contas a pagar salva com sucesso !');
        } catch (\Exception $e) {
            return Redirect()->back()->with('ERRO AO INSERIR CONTA: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        try {
            $conta = ContasAPagar::find($request->idContaM);
            $conta->delete();
            return redirect()->route('contasPagar.index')->with('success', 'Deletado com sucesso !');
        } catch (\Exception $e) {
            return Redirect()->back()->with('error', 'Erro ao deletar' . $e->getMessage());
        }
    }
}
