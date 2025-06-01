@extends('adminlte::page')

@section('title', 'Contas a Receber ')

@section('content_header')
    <h1>Contas a Receber </h1>
@stop
@section('content')
    <x-data-table :itemsPerPage="50" :valueColumnIndex="3" :orderByIndex="4" :responsive="[
        ['targets' => 0, 'responsivePriority' => 1],
        ['targets' => 3, 'responsivePriority' => 2],
        ['targets' => -1, 'responsivePriority' => 3]
    ]" :showTotal="false">

        <thead>
            <tr>
                <th>Cliente</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Vencimento</th>
                <th>Recebimento</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contas as $conta)
                <tr>
                    <td>{{ $conta->cliente->razao_social ?? 'N/A' }}</td>
                    <td>{{ $conta->descricao }}</td>
                    <td>{{ number_format($conta->valor, 2, ',', '.') }}</td>
                    <td>
                        {{ $conta->data_vencimento ? \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') : '-' }}
                    </td>
                    <td>
                        {{ $conta->data_recebimento ? \Carbon\Carbon::parse($conta->data_recebimento)->format('d/m/Y') : '-' }}
                    </td>
                    <td>
                        @php
                            $status = strtolower($conta->status);
                            $badgeClass = match ($status) {
                                'recebido' => 'bg-success',
                                'pendente' => 'bg-warning',
                                'atrasado' => 'bg-danger',
                                default => 'bg-secondary',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ ucfirst($conta->status) }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </x-data-table>
@stop