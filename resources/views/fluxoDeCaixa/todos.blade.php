@extends('adminlte::page')

@section('title', 'caixa')

@section('content_header')
<h1>Fluxo de caixa</h1>
@stop

@section('content')
<a class="btn btn-info create-btn" style="margin-bottom: 2%" data-toggle="modal" data-target="#ModalCreate">
    <i class="fa fa-plus"></i>&nbsp; Incluir &nbsp;
</a>
<table id="caixa" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Data</th>
            <th>Valor</th>
            <th>Tipo</th>
            <th>Plano de contas</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lancamentos as $lancamento)
        <tr>
            <td>{{ $lancamento->id }}</td>
            <td>{{ $lancamento->descricao }}</td>
            <td>{{ date('d/m/Y', strtotime($lancamento->data)) }}</td>
            <td>{{ $lancamento->valor }}</td>
            <td>
                <span class="<?php echo $lancamento->tipo == 'entrada' ? 'entrada' : ($lancamento->tipo == 'entrada' ? 'entrada' : 'saida'); ?>" id="tipo_lanc">{{ $lancamento->tipo }}
                </span>
            </td>
            <td>{{ $lancamento->planoDeContas->descricao }}</td>
            <td>
                <div class="row">
                    <div class="col">
                        <a class="edit-btn" title="Editar" data-id="{{ $lancamento->id }}" data-descricao="{{ $lancamento->descricao }}" data-valor="{{ $lancamento->valor }}" data-tipo="{{ $lancamento->tipo }}" data-plano-contas-id="{{ $lancamento->plano_contas_id }}" data-data-transacao="{{ $lancamento->data_transacao }}" data-toggle="modal" data-target="#ModalCreate"><i class="fa fa-edit"></i></a>
                    </div>

                    <div class="col">
                        <a class="text-danger" title="Excluir" onclick="setaDadosModal({{ $lancamento->id }})"><i data-toggle="modal" data-target=".bd-delete-modal-lg" class="fa fa-trash"></i></a>
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

<!-- Modal delete -->
<div class="modal fade bd-delete-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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

                    <form action="{{ route('delete-lancamento') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <div class="form-group">
                            <input type="hidden" step="0.01" class="form-control" id="idContaM" name="idContaM" value="">
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
<!-- Fim Modal -->
<!-- Modal Create -->
<div class="modal fade bd-new-modal-lg" tabindex="-1" role="dialog" id="ModalCreate" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">

                <div class="col" style="text-align: center">
                    <div class="modal-title" style="text: center">
                        <h6>Inserir lançamento </h6>
                    </div>
                </div>
            </div>
            <div class="modal-body">

                <form id="modalForm" action="" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST"> <!-- Para suportar PUT em caso de edição -->


                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option value="">Selecione um Plano de Contas</option>
                            <option value="entrada">Entrada</option>
                            <option value="saida">Saída</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" required oninput="this.value = this.value.toUpperCase()" placeholder="Digite a descrição">
                    </div>

                    <div class="form-group">
                        <label for="valor">Valor</label>
                        <input type="number" class="form-control" id="valor" name="valor" required placeholder="R$" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="data_transacao">Data da Transação</label>
                        <input type="date" class="form-control" id="data_transacao" name="data_transacao" value="{{ now()->toDateString() }}">
                    </div>

                    <div class="form-group">
                        <label for="plano_contas_id">Plano de Contas</label><br>
                        <select class="form-control select2" id="plano_contas_id" name="plano_contas_id" style="width: 100%;" required>
                            <option value="">Selecione um Plano de Contas</option>
                            @foreach ($planos as $plano)
                            <option value="{{ $plano->id }}">{{ $plano->descricao }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Salvar</button>



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
            </form>
        </div>
    </div>

</div>

<!-- fim modal -->
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/r-3.0.0/sr-1.4.0/datatables.min.css" rel="stylesheet">
<style>
    .bloqueado {
        opacity: 0.5;
        pointer-events: none;
    }

    .pendente {
        background-color: orange;

    }

    .entrada {
        background-color: green;
    }

    .saida {
        background-color: red;
    }

    #tipo_lanc {
        position: relative;
        padding: 2px 8px;
        border-radius: 50px;
        color: #ffffff;
        /* Espaçamento interno para manter a borda longe do texto */
    }

    #tipo_lanc:before {
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/r-3.0.0/sr-1.4.0/datatables.min.js">
</script>

<script>
    function setaDadosModal(idContas) {
        document.getElementById('idContaM').value = idContas;
    }


    $(document).ready(function() {
        $('#plano_contas_id').select2({
            placeholder: "Selecione um Plano de Contas",
            allowClear: true,
            dropdownParent: $('#ModalCreate'),
            theme: 'bootstrap'
        });
    });




    $(document).ready(function() {
        $('#caixa').DataTable({
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
                    targets: 4
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
                let total = api.column(3).data().reduce(function(a, b) {
                    return a + parseFloat(b)
                }, 0)
                let pageTotal = api.column(3, {
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


    // Quando o botão para abrir o modal em modo de edição é clicado
    $('.edit-btn').on('click', function() {
        var lancamentoId = $(this).data('id');
        var descricao = $(this).data('descricao');
        var valor = $(this).data('valor');
        var tipo = $(this).data('tipo');
        var planoContaId = $(this).data('plano-contas-id');
        var dataTransacao = $(this).data('data-transacao');

        // Configura a URL do formulário e o método para edição
        $('#modalForm').attr('action', '/caixa/' + lancamentoId);
        $('#formMethod').val('PUT'); // Mudar o método para PUT para edição

        // Preenche os campos do formulário
        $('#descricao').val(descricao);
        $('#valor').val(valor);
        $('#tipo').val(tipo);
        $('#plano_contas_id').val(planoContaId).trigger('change'); // Para Select2
        $('#data_transacao').val(dataTransacao);

        $('#ModalCreate').modal('show'); // Abrir o modal
    });

    // Quando o botão para criar novo lançamento é clicado
    $('.create-btn').on('click', function() {
        $('#modalForm').attr('action', '{{ route("caixa.store") }}');
        $('#formMethod').val('POST');

        // Limpar os campos do formulário
        $('#modalForm').find('input[type=text], input[type=number], select').val('');

        $('#ModalCreate').modal('show'); // Abrir o modal
    });
</script>

@stop
