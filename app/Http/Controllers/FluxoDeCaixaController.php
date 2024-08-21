<?php

namespace App\Http\Controllers;

use App\Models\FluxoDeCaixa;
use App\Models\PlanoDeContas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Reflector;

class FluxoDeCaixaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $caixa = FluxoDeCaixa::with('planoDeContas')
            // ->whereMonth('data_transacao', now()->month) // Filtra pelo mês atual
            // ->whereYear('data_transacao', now()->year)  // Filtra pelo ano atual
            ->orderBy('id', 'desc') // Ordenando os dados
            ->get();
        $planos = PlanoDeContas::all();
        return view('fluxoDeCaixa.todos', ['lancamentos' => $caixa, 'planos' => $planos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'descricao' => 'required|max:255',
            'valor' => 'required|numeric',
            'data_transacao' => 'required',
            'tipo' => 'required|in:entrada,saida',
            'plano_contas_id' => 'required|integer'
        ]);
        FluxoDeCaixa::create([
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_transacao' => $request->data_transacao,
            'tipo' => $request->tipo,
            'plano_contas_id' => $request->plano_contas_id
        ]);
        sweetalert('Registrado com sucesso!');
        return redirect()->route('caixa.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(FluxoDeCaixa $fluxoDeCaixa) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FluxoDeCaixa $fluxoDeCaixa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $lancamento)
    {
        $request->validate([
            'descricao' => 'required|max:255',
            'valor' => 'required|numeric',
            'data_transacao' => 'required',
            'tipo' => 'required|in:entrada,saida',
            'plano_contas_id' => 'required|integer'
        ]);
        $lanc = FluxoDeCaixa::find($lancamento);
        $lanc->update([
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_transacao' => $request->data_transacao,
            'tipo' => $request->tipo,
            'plano_contas_id' => $request->plano_contas_id
        ]);
        sweetalert('Atualizado com sucesso!');
        return Redirect()->route('caixa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $caixa = FluxoDeCaixa::find($request->idContaM);
        $caixa->delete();
        sweetalert('Deletado com sucesso !');
        return redirect()->route('caixa.index');
    }
}
