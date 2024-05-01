@extends('adminlte::page')

@section('title', 'Clientes')



@section('content_header')
<div class="row" style="text-align: center">
    <div class="col">
        <h4 class="m-0 text-dark">Clientes</h4>
    </div>
</div>

@stop

@section('content')

<a class="btn btn-info" style="margin-bottom: 2%" href='/clientes/create'>&nbsp; + Cliente &nbsp;</a>
<table class="table table-hover" id="clientes" style="width: 100%;">
    <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>FANTASIA</th>
            <th>RAZÃO SOCIAL</th>
            <th>CNPJ/CPF</th>
            <th>VENCIMENTO</th>
            <th>CIDADE</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $cliente)
        <tr>
            <td>{{ $cliente->id }}</td>
            <td>{{ $cliente->nome_fantasia }}</td>
            <td>{{ $cliente->razao_social  }}</td>
            <td>{{ $cliente->cpf_cnpj }}</td>
            <td>{{ \Carbon\Carbon::parse($cliente->vencimento)->format('d/m/Y') }}</td>
            <td>{{ $cliente->cidade }}</td>
            <td>
                <div class="row">
                    <div class="col">
                        <a class="text-warning" title="Editar" href="{{ route('clientes.edit', $cliente) }}"><i class="fa fa-edit"></i></a>
                    </div>

                    <div class="col">
                        <a class="text-danger" title="Excluir" onclick="setaDadosModal({{ $cliente->id }})"><i data-toggle="modal" data-target=".bd-delete-modal-lg" class="fa fa-trash"></i></a>
                    </div>
                    <!--
                    <div class="col">
                        <a class="text-primary" title="Visualizar" href="{{ route('clientes.show', [$cliente->id]) }}"><i class="fa fa-eye"></i></a>
                    </div> -->
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade bd-delete-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">

                <div class="col" style="text-align: center">
                    <div class="modal-title" style="text: center">
                        <h4>Apagar este Cliente?</h4>
                    </div>
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p style="color: red; text-align: center">OBS: Você irá excluir todas as informações sobre este cliente!
                </p>

                <div class="" style="text-align: center">

                    <form action="{{ route('delete-cliente') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <div class="form-group">
                            <input type="hidden" step="0.01" class="form-control" id="idClienteM" name="idClienteM" value="">
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

@endsection

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/r-3.0.0/sr-1.4.0/datatables.min.css" rel="stylesheet">
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/r-3.0.0/sr-1.4.0/datatables.min.js">
</script>
<script>
    function setaDadosModal(idCliente) {
        document.getElementById('idClienteM').value = idCliente;
    }

    $(document).ready(function() {
        $('#clientes').DataTable({
            responsive: true,
            pageLength: 50,
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
                    targets: -1
                }
            ],
            language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json',
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
