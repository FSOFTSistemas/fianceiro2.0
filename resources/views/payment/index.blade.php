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
                    <td>{{ date('d/m/Y', strtotime($conta->data_vencimento)) }}</td>
                    <td>{{ $conta->valor }}</td>
                    <td>
                        @if ($conta->status == 'atrasado')
                            <span class="badge rounded-pill bg-danger">ATRASADO</span>
                        @else
                            <span class="badge rounded-pill bg-orange text-light">PENDENTE</span>
                        @endif
                    </td>
                    <td>
                        <div class="row text-center">
                            <div class="col">
                                <a class="btn btn-primary"
                                    onclick="openModal({{ $conta->id }}, '{{ $conta->cliente->nome_fantasia }}', '{{ date('d/m/Y', strtotime($conta->data_vencimento)) }}', {{ $conta->valor }})">
                                    Receber
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @component('components.modal', [
        'modalId' => 'receiptModal',
        'modalSize' => 'modal-md',
        'modalTitle' => 'Receber',
    ])
        <div class="modal-body">
            <form action="{{ route('pagamentos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input hidden type="number" id="payment_id" name="payment_id" value="">

                <div class="row text-right mb-2">
                    <div class="col">
                        <span class="badge rounded-pill bg-danger" id="dataVenc"></span>
                    </div>
                </div>

                <div class="row text-center mb-2">
                    <div class="col">
                        <h5 id="customer"></h5>
                    </div>
                </div>

                <div class="row text-center mb-2">
                    <div class="col">
                        <h5><b id="value"></b></h5>
                    </div>
                </div>

                <div class="row text-center mb-2">
                    <div class="col">
                        <div class="form-floating">
                            <select class="form-select" id="payment_method" name="payment_method" aria-label=" " required>
                                <option selected value="">Selecione um item</option>
                                @foreach ($paymentMethods as $pm)
                                    <option value="{{ $pm }}">{{ $pm->value }}</option>
                                @endforeach
                            </select>
                            <label for="payment_method">Forma de Pagamento</label>
                        </div>
                    </div>
                </div>

                <div class="row text-center mb-2">
                    <div class="col">
                        <div class="form-floating">
                            <select class="form-select" id="account_plan_id" name="account_plan_id" aria-label=" " required>
                                <option selected value="">Selecione um item</option>
                                @foreach ($accountPlans as $ap)
                                    <option value="{{ $ap->id }}">{{ $ap->descricao }}</option>
                                @endforeach
                            </select>
                            <label for="account_plan_id">Plano de Conta</label>
                        </div>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col">
                        <button class="btn btn-outline-success">Confirmar</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
    @endcomponent
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link
        href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/r-3.0.0/sr-1.4.0/datatables.min.css"
        rel="stylesheet">
@stop

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/r-3.0.0/sr-1.4.0/datatables.min.js">
    </script>
    <script>
        function openModal(paymentId, customer, dataVenc, value) {
            $('#receiptModal').modal('show')
            document.getElementById('payment_id').value = paymentId
            document.getElementById('customer').innerHTML = customer
            document.getElementById('dataVenc').innerHTML = dataVenc
            document.getElementById('value').innerHTML = value.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
        }

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
                        targets: 3
                    },
                    {
                        responsivePriority: 3,
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
