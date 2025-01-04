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
            <label for="cliente_id" class="form-label">Cliente:</label>
            <select 
                name="cliente_id" 
                id="cliente_id" 
                class="form-select select2" 
                style="width: 100%;" 
                {{ isset($contaAReceber) ? 'disabled' : '' }}>
                <option value="" disabled selected>Selecione um cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" 
                        {{ (isset($contaAReceber) && $contaAReceber->cliente_id == $cliente->id) ? 'selected' : '' }}>
                        {{ $cliente->razao_social }}
                    </option>
                @endforeach
            </select>
            @if(isset($contaAReceber))
                <small class="form-text text-muted">Campo desabilitado pois está sendo editado.</small>
            @endif
        </div>

        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <input type="text" class="form-control" id="descricao" name="descricao" value="{{ $contaAReceber->descricao ?? 'Mensalidade Sistema' }}" oninput="this.value = this.value.toUpperCase()">
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
<link rel="stylesheet" href="/css/admin_custom.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme/dist/select2-bootstrap-5.min.css" rel="stylesheet" />
<style>
    .select2-container--bootstrap-5 .select2-selection {
        height: calc(2.25rem + 2px); /* Tamanho ajustado */
        padding: 0.375rem 0.75rem; /* Espaçamento interno */
        font-size: 1rem; /* Tamanho da fonte */
        color: #495057; /* Cor do texto */
        background-color: #fff; /* Fundo */
        border: 1px solid #ced4da; /* Bordas */
        border-radius: 0.375rem; /* Bordas arredondadas */
    }
</style>
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cliente_id').select2({
            theme: 'bootstrap-5', // Ajuste o tema conforme necessário
            placeholder: "Selecione um cliente",
            allowClear: true,
            width: 'resolve' // Ajuste automático da largura ao contêiner
        });
    });
</script>
@stop
