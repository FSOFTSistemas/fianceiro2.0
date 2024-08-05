@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>150</h3>
                <p>New Orders</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($inadiplencia, 2, '.', '') }}<sup style="font-size: 20px">%</sup></h3>
                <p>inadimplência</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="contasReceber" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $clientes }}</h3>
                <p>Clientes cadastrados</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="clientes" class="small-box-footer">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $tt_atradado }}</h3>
                <p>Valores em atraso</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="contasReceber" class="small-box-footer">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Card para o gráfico de recebimentos por mês -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Recebimentos por Mês</h3>
    </div>
    <div class="card-body">
        <canvas id="recebimentosChart" width="400" height="200"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dados passados do backend para o frontend
    const labels = @json($recebimentosLabels);
    const data = @json($recebimentosData);

    // Configuração do gráfico
    const ctxRecebimentos = document.getElementById('recebimentosChart').getContext('2d');
    const recebimentosChart = new Chart(ctxRecebimentos, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Recebimentos (R$)',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!-- Card para o gráfico de acompanhamento do montante -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Acompanhamento do Montante</h3>
    </div>
    <div class="card-body">
        <canvas id="acompanhamentoChart" width="400" height="200"></canvas>
    </div>
</div>

<script>
    // Dados passados do backend para o frontend
    const totalAmount = @json($totalAmount); // Montante total
    const receivedAmount = @json($receivedAmount); // Valor já recebido
    
    // Calcula o valor que falta receber
    const remainingAmount = Math.max(0, totalAmount - receivedAmount);

    const ctxAcompanhamento = document.getElementById('acompanhamentoChart').getContext('2d');
    const acompanhamentoChart = new Chart(ctxAcompanhamento, {
        type: 'bar',
        data: {
            labels: ['Recebido', 'Faltando'],
            datasets: [{
                label: 'Montante Total (R$)',
                data: [receivedAmount, remainingAmount],
                backgroundColor: ['#4caf50', '#ff5722'],
                borderColor: ['#388e3c', '#d32f2f'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: totalAmount, // Define o valor máximo do eixo Y
                    title: {
                        display: true,
                        text: 'Valor (em R$)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Categoria'
                    }
                }
            }
        }
    });
</script>

<!-- Card para a lista de clientes inadimplentes -->
<div class="container mt-5">
    <h1>Contas Atrasadas</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome do Cliente</th>
                <th>Valor</th>
                <th>Tempo de Atraso</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contasAtrasadas as $conta)
                <tr>
                    <td>{{ $conta->cliente_nome }}</td>
                    <td>R$ {{ number_format($conta->valor, 2, ',', '.') }}</td>
                    <td>{{ $conta->tempo_atraso }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Inclua o JS do Bootstrap, se necessário -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

@stop
