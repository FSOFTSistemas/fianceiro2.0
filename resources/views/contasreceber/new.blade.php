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
        <form
            action="{{ isset($contaAReceber) ? route('contasReceber.update', $contaAReceber) : route('contasReceber.store') }}"
            method="POST">
            @csrf
            @if (isset($contaAReceber))
                @method('PUT')
            @endif


            @if (!isset($contaAReceber))
                <div class="form-group">
                    <label for="nParcelas">Número de parcelas:</label>
                    <input type="text" class="form-control" id="nParcelas" name="nParcelas" value="1">
                </div>
            @endif

            <div class="form-group">
                <label for="cliente_id">Cliente:</label>
                <select name="cliente_id" id="cliente_id" class="select2 form-control" style="width: 100%;">
                    <option value="">Selecione um Cliente</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}"
                            {{ isset($contaAReceber) && $contaAReceber->cliente_id == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->cpf_cnpj }} - {{ $cliente->razao_social }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <input type="text" class="form-control" id="descricao" name="descricao"
                    value="{{ $contaAReceber->descricao ?? 'Mensalidade Sistema' }}"
                    oninput="this.value = this.value.toUpperCase()">
            </div>

            <div class="form-group">
                <label for="valor">Valor:</label>
                <input type="text" class="form-control" id="valor" name="valor"
                    value="{{ $contaAReceber->valor ?? '' }}" required>
            </div>

            <div class="form-group">
                <label for="data_vencimento">Data de Vencimento:</label>
                <input type="date" class="form-control" id="data_vencimento" name="data_vencimento"
                    value="{{ $contaAReceber->data_vencimento ?? '' }}" required>
                <small>A data deve ser do mês atual</small>
            </div>
            @if (isset($contaAReceber))
                <div class="form-group">
                    <label for="data_recebimento">Data de Recebimento:</label>
                    <input type="date" class="form-control" id="data_recebimento" name="data_recebimento"
                        value="{{ $contaAReceber->data_recebimento ?? '' }}">
                </div>
            @endif


            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" class="form-control">
                    <option value="pendente"
                        {{ isset($contaAReceber) && $contaAReceber->status == 'pendente' ? 'selected' : '' }}>Pendente
                    </option>
                    <option value="recebido"
                        {{ isset($contaAReceber) && $contaAReceber->status == 'recebido' ? 'selected' : '' }}>Recebido
                    </option>
                    <option value="atrasado"
                        {{ isset($contaAReceber) && $contaAReceber->status == 'atrasado' ? 'selected' : '' }}>Atrasado
                    </option>
                </select>
            </div>

            <button type="submit" style="width: 100%;"
                class="btn btn-primary">{{ isset($contaAReceber) ? 'Atualizar' : 'Criar' }}</button>
        </form>
    </div>
@endsection

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    

@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/i18n/pt-BR.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Selecione os itens',
                width: '100%',
            });
        });
    </script>
@stop
