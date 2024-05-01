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
<div>
    <h5>{{ isset($contaAReceber) ? 'Editar Conta' : 'Nova Conta a Receber' }}</h5>
    <form action="{{ isset($contaAReceber) ? route('contasReceber.update', $contaAReceber) : route('contasReceber.store') }}" method="POST">
        @csrf
        @if(isset($contaAReceber))
            @method('PUT')
        @endif


        @if(!isset($contaAReceber))
        <div class="form-group">
            <label for="nParcelas">Número de parcelas:</label>
            <input type="text" class="form-control" id="nParcelas" name="nParcelas" value="1">
        </div>
        @endif

        <div class="form-group">
            <label for="cliente_id">Cliente:</label>
            <select name="cliente_id" id="cliente_id" class="form-control" {{ isset($contaAReceber) ? 'disabled': '' }}>
                @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ (isset($contaAReceber) && $contaAReceber->cliente_id == $cliente->id) ? 'selected' : '' }}>{{ $cliente->nome_fantasia }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <input type="text" class="form-control" id="descricao" name="descricao" value="{{ $contaAReceber->descricao ?? 'Mensalidade Sistema' }}">
        </div>

        <div class="form-group">
            <label for="valor">Valor:</label>
            <input type="text" class="form-control" id="valor" name="valor" value="{{ $contaAReceber->valor ?? '' }}" required>
        </div>

        <div class="form-group">
            <label for="data_vencimento">Data de Vencimento:</label>
            <input type="date" class="form-control" id="data_vencimento" name="data_vencimento" value="{{ $contaAReceber->data_vencimento ?? '' }}" required>
            <small>A data deve ser do mês atual</small>
        </div>
        @if(isset($contaAReceber))
            <div class="form-group">
                <label for="data_recebimento">Data de Recebimento:</label>
                <input type="date" class="form-control" id="data_recebimento" name="data_recebimento" value="{{ $contaAReceber->data_recebimento ?? '' }}">
            </div>
        @endif


        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control">
                <option value="pendente" {{ (isset($contaAReceber) && $contaAReceber->status == 'pendente') ? 'selected' : '' }}>Pendente</option>
                <option value="recebido" {{ (isset($contaAReceber) && $contaAReceber->status == 'recebido') ? 'selected' : '' }}>Recebido</option>
                <option value="atrasado" {{ (isset($contaAReceber) && $contaAReceber->status == 'atrasado') ? 'selected' : '' }}>Atrasado</option>
            </select>
        </div>

        <button type="submit" style="width: 100%;" class="btn btn-primary">{{ isset($contaAReceber) ? 'Atualizar' : 'Criar' }}</button>
    </form>
</div>
@endsection

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
@stop
