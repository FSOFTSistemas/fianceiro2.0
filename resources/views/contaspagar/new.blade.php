@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@stop

@section('content')
<!-- resources/views/contas_a_pagar/form.blade.php -->
<form method="POST" action="{{ isset($conta) ? route('contasPagar.update', $conta->id) : route('contasPagar.store') }}" class="p-4">
    @csrf
    @if(isset($conta))
        @method('PUT')
    @endif

    @if(!isset($conta))
    <div class="form-group">
        <label for="nParcelas" class="form-label">Número de parcelas:</label>
        <input type="text" class="form-control" name="nParcelas" id="nParcelas" value="1" required>
    </div>
    @endif
    <div class="form-group">
        <label for="fornecedor" class="form-label">Fornecedor:</label>
        <input type="text" class="form-control" name="fornecedor" id="fornecedor" value="{{ old('fornecedor', $conta->fornecedor ?? '') }}"oninput="this.value = this.value.toUpperCase()">
    </div>

    <div class="form-group">
        <label for="descricao" class="form-label">Descrição:</label>
        <input type="text" class="form-control" name="descricao" id="descricao" value="{{ old('descricao', $conta->descricao ?? '') }}" required oninput="this.value = this.value.toUpperCase()">
    </div>

    <div class="form-group">
        <label for="valor" class="form-label">Valor:</label>
        <input type="number" class="form-control" name="valor" id="valor" step="0.01" value="{{ old('valor', $conta->valor ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="data_vencimento" class="form-label">Data de Vencimento:</label>
        <input type="date" class="form-control" name="data_vencimento" id="data_vencimento" value="{{ old('data_vencimento', $conta->data_vencimento ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="data_pagamento" class="form-label">Data de Pagamento:</label>
        <input type="date" class="form-control" name="data_pagamento" id="data_pagamento" value="{{ old('data_pagamento', $conta->data_pagamento ?? '') }}">
    </div>

    <div class="form-group">
        <label for="status" class="form-label">Status:</label>
        <select class="form-control" name="status" id="status" required>
            <option value="pendente" {{ (old('status', $conta->status ?? '') == 'pendente') ? 'selected' : '' }}>Pendente</option>
            <option value="pago" {{ (old('status', $conta->status ?? '') == 'pago') ? 'selected' : '' }}>Pago</option>
            <option value="atrasado" {{ (old('status', $conta->status ?? '') == 'atrasado') ? 'selected' : '' }}>Atrasado</option>
        </select>
    </div>

    <button type="submit" style="width: 100%;" class="btn btn-primary">{{ isset($conta) ? 'Atualizar' : 'Criar' }}</button>
</form>


@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
@stop
