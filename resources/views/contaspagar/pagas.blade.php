@extends('adminlte::page')

@section('title', 'Contas pagas')

@section('content_header')

@stop

@section('content')
    <div class="card mb-3">
        <div class="card-body text-center">
            <form method="GET" action="{{ route('contasApagar.pagas') }}"
                class="d-flex flex-wrap justify-content-center gap-2">
                @foreach (range(1, 12) as $mes)
                    @php
                        $nomeMes = \Carbon\Carbon::create()->month($mes)->locale('pt_BR')->isoFormat('MMM');
                    @endphp
                    <button type="submit" name="mes" value="{{ $mes }}"
                        class="btn btn-outline-primary mes-btn {{ request('mes', now()->month) == $mes ? 'active' : '' }}">
                        {{ ucfirst($nomeMes) }}
                    </button>
                @endforeach
            </form>
        </div>
    </div>

    @component('components.data-table', [
        'uniqueId' => 'contasPagas',
        'orderByIndex' => 0,
        'valueColumnIndex' => 2,
        'itemsPerPage' => 10,
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
            @foreach ($cPagar as $conta)
                <tr>
                    <td>{{ $conta->id }}</td>
                    <td>{{ $conta->descricao }}</td>
                    <td>{{ $conta->valor }}</td>
                    <td>{{ date('d/m/Y', strtotime($conta->data_vencimento)) }}</td>
                    <td>{{ $conta->data_recebimento ? date('d/m/Y', strtotime($conta->data_recebimento)) : '' }}</td>
                    <td><span
                            class="{{ $conta->status == 'pendente' ? 'pendente' : ($conta->status == 'pago' ? 'pago' : 'atrasado') }}"
                            id="estado">{{ $conta->status }}</span></td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#modal-view-{{ $conta->id }}">
                            👁️ Ver
                        </button>
                    </td>
                </tr>


                @include('contaspagar.modals.view')
            @endforeach
        </tbody>
    @endcomponent

@stop

@section('css')
<style>
    .mes-btn {
        flex: 1 0 calc(100% / 6 - 10px); /* 2 linhas de 6 colunas com espaçamento */
        min-width: 100px;
    }

    @media (max-width: 768px) {
        .mes-btn {
            flex: 1 0 calc(100% / 3 - 10px); /* 4 linhas de 3 colunas em telas menores */
        }
    }

    .btn-outline-primary.active {
        background-color: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }
</style>
@stop

@section('js')

@stop
