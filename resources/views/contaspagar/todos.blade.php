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

        <div class="row">
            <!-- Filtro de Status -->
            <div class="col-md-10">
                <select class="js-example-basic-multiple w-100" name="status[]" multiple="multiple">
                    <option value="">Status</option>
                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="pago" {{ request('status') == 'pago' ? 'selected' : '' }}>Pago</option>
                    <option value="atrasado" {{ request('status') == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-block">Aplicar Filtros</button>
            </div>
        </div>
    </form>



    <table id="contas" style="width: 100%;">
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
                        <span class="<?php echo $conta->status == 'pendente' ? 'pendente' : ($conta->status == 'pago' ? 'pago' : 'atrasado'); ?>" id="estado">{{ $conta->status }}
                        </span>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col">
                                <a class="text-warning" title="Editar" href="{{ route('contasPagar.edit', $conta) }}"><i
                                        class="fa fa-edit"></i></a>
                            </div>

                            <div class="col">
                                <a class="text-danger" title="Excluir" onclick="setaDadosModal({{ $conta->id }})"><i
                                        data-toggle="modal" data-target=".bd-delete-modal-lg" class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>


    <!-- Modal -->
    <div class="modal fade bd-delete-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">

                    <div class="col" style="text-align: center">
                        <div class="modal-title" style="text: center">
                            <h4>Apagar esta conta?</h4>
                        </div>
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <p style="color: red; text-align: center">Atenção: esssa ação não tem volta !
                    </p>

                    <div class="" style="text-align: center">

                        <form action="{{ route('delete-contasPagar') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
                            <div class="form-group">
                                <input type="hidden" step="0.01" class="form-control" id="idContaM"
                                    name="idContaM" value="">
                            </div>

                            <div class="text-center">
                                <button type="submit" style="width: 50%;" class="btn btn-danger">EXCLUIR</button>
                            </div>
                            <br>
                        </form>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim modal -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
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

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
    <script>
        function setaDadosModal(idContas) {
            document.getElementById('idContaM').value = idContas;
        }

        $(document).ready(function() {
            $('#contas').DataTable({
                responsive: true,
                pageLength: 50,
                "order": [
                    [6, "asc"]
                ],
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 5
                    },

                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json',
                },
                footerCallback: function(row, data, start, end, display) {
                    let api = this.api();
                    let total = api.column(2).data().reduce(function(a, b) {
                        return a + parseFloat(b)
                    }, 0)
                    let pageTotal = api.column(2, {
                        page: 'current'
                    }).data().reduce(function(a, b) {
                        return a + parseFloat(b);
                    }, 0);
                    $(api.column(6).footer()).html('Total da página: R$ ' + pageTotal.toFixed(2) +
                        ' de (R$ ' + total.toFixed(2) + ')');
                },
                fixedHeader: {
                    header: false,
                    footer: true
                },
                layout: {
                    topStart: 'buttons',
                    top2Start: 'pageLength'
                },
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="fa fa-clone text-secondary"></i>',
                        titleAttr: 'Copiar',
                        download: 'open'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel text-success"></i>',
                        titleAttr: 'Excel',
                        download: 'open',
                        title: 'Relatório de Clientes'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf text-danger"></i>',
                        titleAttr: 'PDF',
                        download: 'open',
                        title: 'Relatório de Clientes'
                    }
                ]
            });
        });
    </script>

@stop
