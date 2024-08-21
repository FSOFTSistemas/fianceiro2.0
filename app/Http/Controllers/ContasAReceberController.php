<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ContasAReceber;
use App\Services\ContasServices;
use Illuminate\Http\Request;

class ContasAReceberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aReceber = ContasAReceber::all();
        return view('contasreceber.todos', ['aReceber' => $aReceber]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cliente = Cliente::all();
        return view('contasreceber.new', ['clientes' => $cliente]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nParcelas'       => 'required',
            'cliente_id'      => 'required',
            'valor'           => 'required',
            'data_vencimento' => 'required',
            'status'          => 'required'
        ]);
        $vencimento = $request->data_vencimento;
        if ($request->nParcelas > 1) {
            for ($i = 0; $i < $request->nParcelas; $i++) {
                $venc = ContasServices::proximoMes($vencimento);
                ContasAReceber::create([
                    'cliente_id'      => $request->cliente_id,
                    'descricao'       => $request->descricao,
                    'valor'           => $request->valor,
                    'data_vencimento' => $venc,
                    'status'          => $request->status
                ]);
                $vencimento = $venc;
            }
        } else {
            ContasAReceber::create([
                'cliente_id'      => $request->cliente_id,
                'descricao'       => $request->descricao,
                'valor'           => $request->valor,
                'data_vencimento' => $request->data_vencimento,
                'status'          => $request->status
            ]);
        }
        sweetalert('Contas a receber salva com sucesso!');
        return Redirect()->route('contasReceber.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(ContasAReceber $contasAReceber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($contasAReceber)
    {
        $conta = ContasAReceber::find($contasAReceber);
        $cliente = Cliente::all();
        return view('contasreceber.new', ['clientes' => $cliente, 'contaAReceber' => $conta]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $contasAReceber)
    {
        $conta = ContasAReceber::find($contasAReceber);
        $request->validate([
            'valor'           => 'required',
            'data_vencimento' => 'required',
            'status'          => 'required'
        ]);
        $conta->update([
            'valor'           => $request->valor,
            'data_vencimento' => $request->data_vencimento,
            'status'          => $request->status
        ]);
        sweetalert('Contas a receber alterada com sucesso!');
        return Redirect()->route('contasReceber.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $conta = ContasAReceber::find($request->idContaM);
        $conta->delete();
        sweetalert('Deletado com sucesso !');
        return redirect()->route('contasReceber.index');
    }
}
