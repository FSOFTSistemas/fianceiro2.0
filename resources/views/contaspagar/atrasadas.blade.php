@extends('adminlte::page')

@section('title', 'Contas pagas')

@section('content_header')

@stop

@section('content')


    @component('components.data-table', [
        'uniqueId' => 'contasPagas',
        'orderByIndex' => 0,
        'valueColumnIndex' => 2,
        'itemsPerPage' => 30,
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
            @foreach ($contas as $conta)
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
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#exampleModal-{{ $conta->id }}">💰 Pagar</button>
                    </td>
                </tr>
                @include('contaspagar.modals.informarPagamento', ['conta' => $conta])
            @endforeach
        </tbody>
    @endcomponent

@stop

@section('css')

@stop

@section('js')
@stop
