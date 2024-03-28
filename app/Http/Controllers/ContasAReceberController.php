<?php

namespace App\Http\Controllers;

use App\Models\ContasAReceber;
use Illuminate\Http\Request;

class ContasAReceberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contasreceber.todos');
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
    public function show(ContasAReceber $contasAReceber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContasAReceber $contasAReceber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContasAReceber $contasAReceber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContasAReceber $contasAReceber)
    {
        //
    }
}
