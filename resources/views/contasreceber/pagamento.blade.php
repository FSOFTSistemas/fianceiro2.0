@extends('adminlte::page')

@section('title', 'pagamento')

@section('content_header')
<h5>Pagamento</h5>
@stop

@section('content')
<table class="table table-hover" id="clientes" style="width: 100%;">
    <thead class="table-primary">
        
        <tr>
            <th>ID</th>
            <th>Fantasia</th>
            <th>Razão Social</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $cli)
        <tr>
            <td>{{ $cli->id }}</td>
            <td>{{ $cli->razao_social }}</td>
            <td>{{ $cli->razao_social  }}</td>
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
        var table = $('#clientes').DataTable({
            responsive: true,
            pageLength: 50,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json',
            },
        });

        $('#clientes tbody').on('dblclick', 'tr', function() {
            console.log('estou aqui');
            var id = table.row(this).data();

            window.location.href = '/receber-cliente/' + id[0];

        });



    });
</script>

@stop
