<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ContasAReceber;
use DateTime;
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
        try {

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
                    $venc = $this->proximoMes($vencimento);
                    ContasAReceber::create([
                        'cliente_id'      => $request->cliente_id,
                        'descricao'       => $request->descricao,
                        'valor'           => $request->valor,
                        'data_vencimento' => $venc,
                        'status'          => $request->status
                    ]);
                    $vencimento = $venc;
                }
            }else{
                ContasAReceber::create([
                    'cliente_id'      => $request->cliente_id,
                    'descricao'       => $request->descricao,
                    'valor'           => $request->valor,
                    'data_vencimento' => $request->data_vencimento,
                    'status'          => $request->status
                ]);
            }


            return Redirect()->route('contasReceber.index')->with('success', 'Contas a receber salva com sucesso !');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return Redirect()->back()->with('ERRO AO INSERIR CONTA: ' . $e->getMessage());
        }
    }

    public function proximoMes($dataOriginal)
    {
        $data = new DateTime($dataOriginal);
        $data->modify('+1 month');

        // $diaDaSemana = $data->format('w'); // 'w' retorna um número de 0 (domingo) a 6 (sábado)
        // if ($diaDaSemana == 6) {
        //     $data->modify('+2 days');
        // }
        // elseif ($diaDaSemana == 0) {
        //     $data->modify('+1 day');
        // }

        return $data->format('Y-m-d');
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
        try{
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

            return Redirect()->route('contasReceber.index')->with('success', 'Contas a receber alterada com sucesso !');
        }catch(\Exception $e){
            return Redirect()->back()->with('ERRO AO ALTERAR CONTA: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContasAReceber $contasAReceber)
    {
        //
    }
}
