@extends('adminlte::page')

@section('title', 'Contas a receber')

@section('content_header')
    <a class="btn btn-success float-right mb-3" href='/contasReceber/create'>&nbsp; + Incluir &nbsp;</a>
    <div class="row" style="text-align: center">
        <div class="col">
            <h4 class="m-0 text-dark">Contas a receber</h4>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
@stop

@section('content')

    <form method="GET" action="{{ route('contasReceber.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="data_inicio">Data Início</label>
                <input type="date" name="data_inicio" id="data_inicio" class="form-control"
                    value="{{ request('data_inicio') }}">
            </div>
            <div class="col-md-3">
                <label for="data_fim">Data Fim</label>
                <input type="date" name="data_fim" id="data_fim" class="form-control" value="{{ request('data_fim') }}">
            </div>
            <div class="col-md-3">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Todos</option>
                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="recebido" {{ request('status') == 'recebido' ? 'selected' : '' }}>Recebido</option>
                    <option value="atrasado" {{ request('status') == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                </select>
            </div>
            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('contasReceber.index') }}" class="btn btn-secondary">Limpar</a>
            </div>
        </div>
    </form>


    <table id="contas" style="width: 100%;">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Dt. Vencimento</th>
                <th>Dt. Pagamento</th>
                <th>Valor original</th>
                <th>Valor pago</th>
                <th>Situação</th>
                <th> $ </th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($aReceber as $receber)
                <tr>
                    <td>{{ $receber->id }}</td>
                    <td>{{ $receber->cliente->razao_social }}</td>
                    <td>{{ date('d/m/Y', strtotime($receber->data_vencimento)) }}</td>
                    <td>{{ $receber->data_recebimento ? date('d/m/Y', strtotime($receber->data_recebimento)) : '' }}</td>
                    <td>{{ $receber->valor }}</td>
                    <td>{{ $receber->valor_pago }}</td>
                    <td>
                        <span class="<?php echo $receber->status == 'pendente' ? 'pendente' : ($receber->status == 'recebido' ? 'recebido' : 'atrasado'); ?>" id="estado">{{ $receber->status }}
                        </span>
                    </td>
                    <td>
                        <div class="col">
                            <a class="text-success" title="Receber" data-toggle="modal" data-target=".bd-receber-modal-lg"
                                onclick="abrirModalReceber({{ $receber->id }}, '{{ $receber->valor }}')">
                                <button class="btn btn-sm btn-success">
                                    Receber
                                </button>
                            </a>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col">
                                <a class="text-warning" title="Editar"
                                    href="{{ route('contasReceber.edit', $receber) }}"><i class="fa fa-edit"></i></a>
                            </div>

                            <div class="col">
                                <a class="text-danger" title="Excluir" onclick="setaDadosModal({{ $receber->id }})"><i
                                        data-toggle="modal" data-target=".bd-delete-modal-lg" class="fa fa-trash"></i>
                                </a>
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
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="modal fade bd-delete-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">

                    <div class="col" style="text-align: center">
                        <div class="modal-title" style="text: center">
                            <h4>Apagar este conta?</h4>
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

                        <form action="{{ route('delete-receber') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
                            <div class="form-group">
                                <input type="hidden" step="0.01" class="form-control" id="idContaM" name="idContaM"
                                    value="">
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

    <div class="modal fade bd-receber-modal-lg" tabindex="-1" role="dialog" aria-labelledby="receberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h4 class="modal-title w-100 text-center">Confirmar recebimento</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p>Tem certeza que deseja marcar esta conta como <strong>Recebida</strong>?</p>
                    <p id="valorReceberTexto" class="font-weight-bold text-success"></p>
                    <form action="{{ route('pagamentos.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_id" id="payment_id" value="">
                        <button type="submit" class="btn btn-success">Confirmar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
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

        .recebido {
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
    <script>
        function setaDadosModal(idContas) {
            document.getElementById('idContaM').value = idContas;
        }

        function abrirModalReceber(id, valor) {
            document.getElementById('payment_id').value = id;
            document.getElementById('valorReceberTexto').innerText = 'Valor: R$ ' + parseFloat(valor).toFixed(2);
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
                        targets: 1
                    },
                    {
                        responsivePriority: 2,
                        targets: 7
                    },
                    {
                        responsivePriority: 2,
                        targets: 6
                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json',
                },
                footerCallback: function(row, data, start, end, display) {
                    let api = this.api();
                    let total = api.column(4).data().reduce(function(a, b) {
                        return a + parseFloat(b)
                    }, 0)
                    let pageTotal = api.column(4, {
                        page: 'current'
                    }).data().reduce(function(a, b) {
                        return a + parseFloat(b);
                    }, 0);
                    $(api.column(5).footer()).html('Total da página: R$ ' + pageTotal.toFixed(2) +
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
