@extends('adminlte::page')

@section('title', 'Novo Cliente')

@section('content_header')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@stop

@section('content')
<div class="card-header">{{ isset($cliente) ? 'Editar Cliente' : 'Novo Cliente' }}</div>


<div class="card-body">
    <form method="POST" action="{{ isset($cliente) ? route('clientes.update', $cliente->id) : route('clientes.store') }}">
        @csrf
        @if(isset($cliente))
        @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-6">
                <!-- CPF/CNPJ com botão de pesquisa alinhado -->
                <div class="form-group">
                    <label for="cpf_cnpj">CPF/CNPJ</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="{{ old('cpf_cnpj', isset($cliente) ? $cliente->cpf_cnpj : '') }}" required>
                        <div class="input-group-append">
                            <button id="cnpj_button" type="button" class="btn btn-light"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <small id="cpf_cnpj_help" class="form-text text-muted">Apenas números.</small>
                </div>
            </div>
            <div class="col-md-6">
                <!-- IE -->
                <div class="form-group">
                    <label for="ie">IE</label>
                    <input type="number" class="form-control" id="ie" name="ie" value="{{ old('ie', isset($cliente) ? $cliente->ie : '') }}" oninput="this.value = this.value.toUpperCase()">
                    <small id="ie_help" class="form-text text-muted">Apenas números.</small>
                </div>
            </div>
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
        <div class="row">
            <div class="col-md-6">
                <!-- Situação -->
                <div class="form-group">
                    <label for="situacao">Situação</label>
                    <select class="form-control" id="situacao" name="situacao" required>
                        <option value="Ativa" {{ old('situacao', isset($cliente) ? $cliente->situacao : '') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="Inativa" {{ old('situacao', isset($cliente) ? $cliente->situacao : '') == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <!-- CEP -->
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" class="form-control" id="cep" name="cep" value="{{ old('cep', isset($cliente) ? $cliente->cep : '') }}" pattern="[0-9]{5}-[0-9]{3}">
                    <small id="cep_help" class="form-text text-muted">Formato: 12345-678.</small>
                </div>
            </div>
        </div>
        <!-- Endereço -->
        <div class="form-group">
            <label for="rua">Rua</label>
            <input type="text" class="form-control" id="rua" name="rua" value="{{ old('rua', isset($cliente) ? $cliente->rua : '') }}" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cidade">Cidade</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" value="{{ old('cidade', isset($cliente) ? $cliente->cidade : '') }}" oninput="this.value = this.value.toUpperCase()">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <input type="text" maxlength="2" class="form-control" id="estado" name="estado" value="{{ old('estado', isset($cliente) ? $cliente->estado : '') }}" oninput="this.value = this.value.toUpperCase()">
                    <small id="cpf_cnpj_help" class="form-text text-muted">Apenas a sigla ex.: PE</small>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="bairro">Bairro</label>
            <input type="text" class="form-control" id="bairro" name="bairro" value="{{ old('bairro', isset($cliente) ? $cliente->bairro : '') }}" oninput="this.value = this.value.toUpperCase()">
        </div>

        <!-- Data de Vencimento -->
        <div class="form-group">
            <label for="vencimento">Data de Vencimento</label>
            <input type="date" class="form-control" id="vencimento" name="vencimento" value="{{ old('vencimento', isset($cliente) ? \Carbon\Carbon::parse($cliente->vencimento)->format('Y-m-d') : '') }}" required>
        </div>
        <br><br>

        <div style="text-align: center;">
            <button type="submit" class="btn btn-primary" style=" width: 100%;">{{ isset($cliente) ? 'Atualizar' : 'Salvar' }}</button>
        </div>

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


    $('#cnpj_button').click(function() {
        var cnpj = $('#cpf_cnpj').val();
        cnpj = sn(cnpj);
        $.ajax({
            url: 'https://publica.cnpj.ws/cnpj/' + cnpj,
            dataType: 'json',
            success: function(data) {
                console.log("sucesso!");
                $('#nome_fantasia').val(data.estabelecimento.nome_fantasia);
                $('#razao_social').val(data.razao_social);
                $('#ie').val(data.estabelecimento.inscricoes_estaduais[0].inscricao_estadual);
                $('#cep').val(data.estabelecimento.cep);
                $('#rua').val(data.estabelecimento.logradouro);
                $('#bairro').val(data.estabelecimento.bairro);
                $('#cidade').val(data.estabelecimento.cidade.nome);
                $('#estado').val(data.estabelecimento.estado.sigla);

            },
            error: function() {
                alert('CNPJ não encontrado ou API indisponível');
            }
        });
    });

    function sn(cnpj) {
        ; //somente numeros
        const regex = /[^0-9]/g;
        return cnpj.replace(regex, '');
    }
</script>
@stop
