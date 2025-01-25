@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    {{-- linha 1 --}}
    {{-- Clientes cadastrados --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $clientes }}</h3>
                    <p>Clientes cadastrados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="clientes" class="small-box-footer">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        {{-- Contas a receber --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $areceber }}</h3>
                    <p>A receber</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="contasReceber" class="small-box-footer">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        {{-- Contas a pagar --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $apagar }}</h3>
                    <p>Contas a pagar</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="contasPagar" class="small-box-footer">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- Atrasados --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $areceber - $apagar }}</h3>
                    <p>Previsão de resutado</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    {{-- linha 2 --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $receivedAmount }}</h3>
                    <p>Valor recebido</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="contasReceber" class="small-box-footer">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $pendente }}</h3>
                    <p>Valor Pendente</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="contasReceber" class="small-box-footer">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $tt_atradado }}</h3>
                    <p>Valores em atraso</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="contasReceber" class="small-box-footer">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $inadiplencia }}</h3>
                    <p>Inadiplencia %</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="contasReceber" class="small-box-footer">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Card para o gráfico -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Evolução dos Valores por Data</h3>
        </div>
        <div class="card-body">
            <canvas id="pieChart" width="400" height="200"></canvas>
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

    <!-- Importar Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script para o gráfico -->
    <script>
        const dueDateLabels = @json(
            $groupedByDueDate->pluck('data_vencimento')->map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('d/m/Y');
            }));

        const totalToReceive = @json($groupedByDueDate->pluck('total_valor')); // Dados para valores a receber
        const totalReceived = @json($groupedByReceivedDate->pluck('total_valor')); // Dados para valores recebidos

        var ctx = document.getElementById('pieChart').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line', // Gráfico de linha
            data: {
                labels: dueDateLabels, // Datas de vencimento no eixo X
                datasets: [{
                        label: 'Valores a Receber', // Legenda da linha
                        data: totalToReceive, // Dados
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Cor da área preenchida
                        borderColor: 'rgba(75, 192, 192, 1)', // Cor da linha
                        borderWidth: 2
                    },
                    {
                        label: 'Valores Recebidos', // Legenda da segunda linha
                        data: totalReceived, // Dados
                        backgroundColor: 'rgba(192, 75, 75, 0.2)', // Cor da área preenchida
                        borderColor: 'rgba(192, 75, 75, 1)', // Cor da linha
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top' // Exibe a legenda no topo
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                let value = tooltipItem.raw;
                                return `Total: ${value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Datas de Vencimento' // Legenda do eixo X
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Valores' // Legenda do eixo Y
                        }
                    }
                }
            }
        });
    </script>

@stop
