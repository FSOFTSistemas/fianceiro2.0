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
<table class="table table-hover" id="clientes">
    <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>FANTASIA</th>
            <th>RAZÃO SOCIAL</th>
            <th>CNPJ/CPF</th>
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
            <td><a title="Editar" href='#' class='text-warning'><i class="fa fa-edit"></i></a>
                <a title="Excluir" class='text-danger'><i class="fa fa-trash"></i></a>
                <a title="Visualizar" href='#' class='text-primary'><i class="fa fa-eye"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
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
    $(document).ready(function() {
        $('#clientes').DataTable({
            responsive: true,
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 2,
                    targets: -1
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json',
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
