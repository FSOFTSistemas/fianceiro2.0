@extends('adminlte::page')

@section('title', 'Contas')

@section('content_header')
    <h1>Contas</h1>
@stop

@section('content')
<table class="table table-hover" id="contas" style="width: 100%;">
    <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Vencimento</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($Conta as $c)
        <tr>

            <td>{{ $c->id }}</td>
            <td>{{ $c->descricao }}</td>
            <td>{{ $c->valor  }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
@section('css')
<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
<link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/r-3.0.0/sr-1.4.0/datatables.min.css" rel="stylesheet">
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/r-3.0.0/sr-1.4.0/datatables.min.js">
</script>
<script>



    $(document).ready(function() {
        var table = $('#contas').DataTable({
            responsive: true,
            pageLength: 50,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json',
            },
        });

        $('#contas tbody').on('click', 'tr', function() {
            console.log('estou aqui');
            var id = table.row(this).data();

        });



    });
</script>

@stop
