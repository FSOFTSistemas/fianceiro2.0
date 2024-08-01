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
    // Dados de recebimentos por mês
    const labels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    const data = [1500, 2000, 1800, 2200, 2500, 2300, 2100, 2600, 2400, 2700, 2900, 3000];

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
    // Dados do gráfico de acompanhamento
    const totalAmount = 10000; // Montante total
    const receivedAmount = 6000; // Valor já recebido
    const remainingAmount = totalAmount - receivedAmount; // Valor que falta receber

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
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!-- Card para a lista de clientes inadimplentes -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Clientes Inadimplentes</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                </tr>
            </thead>
            <tbody>
                <!-- Lista fictícia de clientes inadimplentes -->
                <tr>
                    <td>João Silva</td>
                    <td>joao.silva@example.com</td>
                    <td>(11) 99999-9999</td>
                </tr>
                <tr>
                    <td>Maria Oliveira</td>
                    <td>maria.oliveira@example.com</td>
                    <td>(21) 98888-8888</td>
                </tr>
                <tr>
                    <td>Pedro Santos</td>
                    <td>pedro.santos@example.com</td>
                    <td>(31) 97777-7777</td>
                </tr>
                <tr>
                    <td>Ana Souza</td>
                    <td>ana.souza@example.com</td>
                    <td>(41) 96666-6666</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@stop
