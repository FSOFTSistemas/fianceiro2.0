@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <a class="btn btn-success float-right" style="margin-bottom: 2%" href='/contasPagar/create'>&nbsp; + Incluir &nbsp;</a>
    <div class="row" style="text-align: center">
        <div class="col">
            <h5 class="m-0 text-dark">Contas a pagar</h5>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
@stop

@section('content')

    <!-- Formulário de Filtro -->
    <form action="{{ route('contasPagar.index') }}" method="GET" class="mb-3">
        <!-- Card para Data de Vencimento -->
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 text-dark">Data de Vencimento</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" name="data_vencimento_inicio" class="form-control"
                                    value="{{ request('data_vencimento_inicio') }}" placeholder="Início">
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="data_vencimento_fim" class="form-control"
                                    value="{{ request('data_vencimento_fim') }}" placeholder="Fim">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card para Data de Pagamento -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 text-dark">Data de Pagamento</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" name="data_pagamento_inicio" class="form-control"
                                    value="{{ request('data_pagamento_inicio') }}" placeholder="Início">
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="data_pagamento_fim" class="form-control"
                                    value="{{ request('data_pagamento_fim') }}" placeholder="Fim">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card para Status -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h6 class="m-0 text-dark">Status</h6>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="status[]" value="pendente"
                                id="status_pendente"
                                {{ is_array(request('status')) && in_array('pendente', request('status')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_pendente">Pendente</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="status[]" value="pago" id="status_pago"
                                {{ is_array(request('status')) && in_array('pago', request('status')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_pago">Pago</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="status[]" value="atrasado"
                                id="status_atrasado"
                                {{ is_array(request('status')) && in_array('atrasado', request('status')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_atrasado">Atrasado</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botão de filtro -->
        <div class="row mb-3">
            <div class="col text-center">
                <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
            </div>
        </div>
    </form>

    <div>
        @component('components.data-table', [
            'uniqueId' => 'contasPagar',
            'orderByIndex' => 0,
            'valueColumnIndex' => 2,
            'itemsPerPage' => 50,
            'responsive' => [['targets' => [0], 'className' => 'all'], ['targets' => '_all', 'className' => 'dt-body-left']],
            'showTotal' => true,
        ])
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Dt. Vencimento</th>
                    <th>Dt. Pagamento</th>
                    <th>Situação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cPagar as $conta)
                    <tr>
                        <td>{{ $conta->id }}</td>
                        <td>{{ $conta->descricao }}</td>
                        <td>{{ $conta->valor }}</td>
                        <td>{{ date('d/m/Y', strtotime($conta->data_vencimento)) }}</td>
                        <td>{{ $conta->data_recebimento ? date('d/m/Y', strtotime($conta->data_recebimento)) : '' }}</td>
                        <td>
                            @if ($conta->status == 'pendente')
                                <span class="badge bg-warning text-dark">Pendente</span>
                            @elseif ($conta->status == 'pago')
                                <span class="badge bg-success">Pago</span>
                            @else
                                <span class="badge bg-danger">Atrasado</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a class="btn btn-sm btn-warning" title="Editar"
                                    href="{{ route('contasPagar.edit', $conta) }}"><i class="fa fa-edit"></i></a>
                                <button class="btn btn-sm btn-danger" title="Excluir"
                                    onclick="setaDadosModal({{ $conta->id }})" data-bs-toggle="modal"
                                    data-bs-target=".bd-delete-modal-lg"><i class="fa fa-trash"></i></button>
                                @if ($conta->status != 'pago')
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal-{{ $conta->id }}">💰 Pagar</button>
                                @endif
                            </div>

                        </td>
                    </tr>
                    @include('contaspagar.modals.delete', ['conta' => $conta])
                    @include('contaspagar.modals.informarPagamento', ['conta' => $conta])
                @endforeach
            </tbody>
        @endcomponent
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link
        href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/r-3.0.0/sr-1.4.0/datatables.min.css"
        rel="stylesheet">
    <style>
        .bloqueado {
            opacity: 0.5;
            pointer-events: none;
        }

        .pendente {
            background-color: orange;

        }

        .pago {
            background-color: green;
        }

        .atrasado {
            background-color: red;
        }

        #estado {
            position: relative;
            padding: 2px 8px;
            border-radius: 50px;
            color: #ffffff;
            /* Espaçamento interno para manter a borda longe do texto */
        }

        #estado:before {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            /* Largura do retângulo */
            height: 100%;
            /* Altura do retângulo */
            border-color: inherit;
            /* Usa a mesma cor do texto para a borda */
            box-sizing: border-box;
            /* Mantém o tamanho da borda dentro do retângulo */
        }
    </style>

@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/r-3.0.0/sr-1.4.0/datatables.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- select2 initialization removed as no longer needed -->
    <script>
        function setaDadosModal(idContas) {
            document.getElementById('idContaM').value = idContas;
        }
    </script>

@stop
