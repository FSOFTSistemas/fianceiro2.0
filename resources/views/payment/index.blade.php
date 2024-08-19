@extends('adminlte::page')

@section('title', 'Pagamentos')

@section('content_header')
    <div class="row" style="text-align: center">
        <div class="col">
            <h4 class="m-0 text-dark">Pagamentos</h4>
        </div>
    </div>
@stop

@section('content')
    <table class="table table-hover" id="pagamentos" style="width: 100%;">
        <thead class="table-primary">
            <tr>
                <th>Cliente</th>
                <th>Data Vencimento</th>
                <th>Valor</th>
                <th>Situação</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contasAReceber as $conta)
                <tr>
                    <td>{{ $conta->cliente->nome_fantasia }}</td>
                    <td>{{ $conta->data_vencimento }}</td>
                    <td>{{ $conta->valor }}</td>
                    <td>
                        @if ($conta->status == 'atrasado')
                            <span class="badge rounded-pill bg-danger">ATRASADO</span>
                        @else
                            <span class="badge rounded-pill bg-orange text-light">PENDENTE</span>
                        @endif
                    </td>
                    <td>
                        <div class="row">
                            {{-- <div class="col">
                                <a class="text-warning" title="Editar" href="{{ route('clientes.edit', $cliente) }}"><i
                                        class="fa fa-edit"></i></a>
                            </div>

                            <div class="col">
                                <a class="text-danger" title="Excluir" onclick="setaDadosModal({{ $cliente->id }})"><i
                                        data-toggle="modal" data-target=".bd-delete-modal-lg" class="fa fa-trash"></i></a>
                            </div> --}}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link
        href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/r-3.0.0/sr-1.4.0/datatables.min.css"
        rel="stylesheet">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/r-3.0.0/sr-1.4.0/datatables.min.js">
    </script>
    <script>
        $(document).ready(function() {
            $('#pagamentos').DataTable({
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
                        title: 'Relatório de Pagamentos'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf text-danger"></i>',
                        titleAttr: 'PDF',
                        download: 'open',
                        title: 'Relatório de Pagamentos'
                    }
                ]
            });
        });
    </script>

@stop
