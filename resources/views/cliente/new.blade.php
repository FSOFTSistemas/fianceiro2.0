@extends('adminlte::page')

@section('title', 'Novo Cliente')

@section('content_header')

@stop

@section('content')
<div class="card-header">{{ isset($cliente) ? 'Editar Cliente' : 'Novo Cliente' }}</div>

<div class="card-body">
    <form method="POST" action="{{ isset($cliente) ? route('clientes.update', $cliente->id) : route('clientes.store') }}">
        @csrf
        @if(isset($cliente))
        @method('PUT')
        @endif

         <!-- CPF/CNPJ -->
         <div class="form-group">
            <label for="cpf_cnpj">CPF/CNPJ</label>
            <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="{{ old('cpf_cnpj', isset($cliente) ? $cliente->cpf_cnpj : '') }}" required>
            <small id="cpf_cnpj_help" class="form-text text-muted">Apenas números.</small>
        </div>

        <!-- IE -->
        <div class="form-group">
            <label for="ie">IE</label>
            <input type="number" class="form-control" id="ie" name="ie" value="{{ old('ie', isset($cliente) ? $cliente->ie : '') }}" oninput="this.value = this.value.toUpperCase()">
            <small id="cpf_cnpj_help" class="form-text text-muted">Apenas números.</small>
        </div>

        <!-- Nome Fantasia -->
        <div class="form-group">
            <label for="nome_fantasia">Nome Fantasia</label>
            <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" value="{{ old('nome_fantasia', isset($cliente) ? $cliente->nome_fantasia : '') }}" oninput="this.value = this.value.toUpperCase()" required>
        </div>

        <!-- Razão Social -->
        <div class="form-group">
            <label for="razao_social">Razão Social</label>
            <input type="text" class="form-control" id="razao_social" name="razao_social" value="{{ old('razao_social', isset($cliente) ? $cliente->razao_social : '') }}" oninput="this.value = this.value.toUpperCase()" required>
        </div>

        <!-- Situação -->
        <div class="form-group">
            <label for="situacao">Situação</label>
            <select class="form-control" id="situacao" name="situacao" required>
                <option value="Ativo" {{ old('situacao', isset($cliente) ? $cliente->situacao : '') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="Inativo" {{ old('situacao', isset($cliente) ? $cliente->situacao : '') == 'Inativo' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>

        <!-- Data de Vencimento -->
        <div class="form-group">
            <label for="vencimento">Data de Vencimento</label>
            <input type="date" class="form-control" id="vencimento" name="vencimento" value="{{ old('vencimento', isset($cliente) ? $cliente->vencimento->format('Y-m-d') : '') }}" required>
        </div>

        <!-- Endereço -->
        <div class="form-group">
            <label for="rua">Rua</label>
            <input type="text" class="form-control" id="rua" name="rua" value="{{ old('rua', isset($cliente) ? $cliente->rua : '') }}" oninput="this.value = this.value.toUpperCase()">
        </div>

        <div class="form-group">
            <label for="bairro">Bairro</label>
            <input type="text" class="form-control" id="bairro" name="bairro" value="{{ old('bairro', isset($cliente) ? $cliente->bairro : '') }}" oninput="this.value = this.value.toUpperCase()">
        </div>

        <div class="form-group">
            <label for="cidade">Cidade</label>
            <input type="text" class="form-control" id="cidade" name="cidade" value="{{ old('cidade', isset($cliente) ? $cliente->cidade : '') }}" oninput="this.value = this.value.toUpperCase()">
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <input type="text" maxlength="2" class="form-control" id="estado" name="estado" value="{{ old('estado', isset($cliente) ? $cliente->estado : '') }}" oninput="this.value = this.value.toUpperCase()">
            <small id="cpf_cnpj_help" class="form-text text-muted">Apenas a sigla ex.: PE</small>
        </div>

        <!-- CEP -->
        <div class="form-group">
            <label for="cep">CEP</label>
            <input type="text" class="form-control" id="cep" name="cep" value="{{ old('cep', isset($cliente) ? $cliente->cep : '') }}" pattern="[0-9]{5}-[0-9]{3}" required>
            <small id="cep_help" class="form-text text-muted">Formato: 12345-678.</small>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($cliente) ? 'Atualizar' : 'Salvar' }}</button>
    </form>
</div>
@endsection

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        // Máscara para CEP
        $('#cep').mask('00000-000');
    });

    $(document).ready(function() {
        $('#cpf_cnpj').on('input', function() {
            var value = $(this).val();
            if (value.length > 12) {
                $(this).mask('00.000.000/0000-00');
            } else {
                $(this).mask('000.000.000-00');
            }
        });
    });
</script>
@stop
