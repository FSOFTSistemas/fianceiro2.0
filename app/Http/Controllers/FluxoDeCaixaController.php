<?php

namespace App\Http\Controllers;

use App\Models\FluxoDeCaixa;
use Illuminate\Http\Request;

class FluxoDeCaixaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $caixa = FluxoDeCaixa::all();
        return view('fluxoDeCaixa.todos', ['lancamentos' => $caixa]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FluxoDeCaixa $fluxoDeCaixa)
    {
        //
    }

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
    public function update(Request $request, FluxoDeCaixa $fluxoDeCaixa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FluxoDeCaixa $fluxoDeCaixa)
    {
        //
    }
}
