<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('cliente.todos', ['clientes' => $clientes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cliente.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cpf_cnpj'      => 'required',
            'ie'            => 'nullable',
            'nome_fantasia' => 'required',
            'razao_social'  => 'required',
            'situacao'      => 'required',
            'vencimento'    => 'required'
        ]);

        Cliente::create([
            'cpf_cnpj'      => $request->cpf_cnpj,
            'ie'            => $request->ie,
            'nome_fantasia' => $request->nome_fantasia,
            'razao_social'  => $request->razao_social,
            'situacao'      => $request->situacao,
            'vencimento'    =>  $request->vencimento,
            'cep'           => $request->cep,
            'rua'           => $request->rua,
            'bairro'        => $request->bairro,
            'cidade'        => $request->cidade,
            'estado'        => $request->estado
        ]);
        sweetalert('Cliente foi salvo com sucesso!');
        return Redirect()->route('clientes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        return view('cliente.new', ['cliente' => $cliente]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('cliente.new', ['cliente' => $cliente]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $cliente)
    {
        $request->validate([
            'cpf_cnpj'      => 'required',
            'ie'            => 'nullable',
            'nome_fantasia' => 'required',
            'razao_social'  => 'required',
            'situacao'      => 'required',
            'vencimento'    => 'required'
        ]);
        $cliente = Cliente::find($cliente);
        $cliente->update([
            'cpf_cnpj'      => $request->cpf_cnpj,
            'ie'            => $request->ie,
            'nome_fantasia' => $request->nome_fantasia,
            'razao_social'  => $request->razao_social,
            'situacao'      => $request->situacao,
            'vencimento'    =>  $request->vencimento,
            'cep'           => $request->cep,
            'rua'           => $request->rua,
            'bairro'        => $request->bairro,
            'cidade'        => $request->cidade,
            'estado'        => $request->estado
        ]);
        sweetalert('Cliente atualizado com sucesso !');
        return Redirect()->route('clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $cliente = Cliente::find($request->idClienteM);
        $cliente->delete();
        sweetalert('Cliente foi deletado com sucesso!');
        return redirect()->route('clientes.index');
    }
}
