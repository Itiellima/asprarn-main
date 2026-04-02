@extends('layouts.main')

@section('title', 'AspraRN - Dashboard')

@section('content')


    @include('dashboard.layouts.nav-dashboard')

    <div class="container text-center alert alert-light">
        <h2>Visao Geral</h2>
    </div>
    <div class="container text-center">
        <div class="row flex m-3 justify-content-center">
            <div class="card m-2 shadow-sm" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Associados cadastrados:</h5>
                    <p class="card-text">Total: {{ count($associados) }}</p>
                    <p>
                        <a href="{{ route('associado.index') }}">Listar</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Situações --}}
    <div class="container text-center">
        <div class="row justify-content-center">
            @if ($situacoes)
                @foreach ($situacoes as $situacao)
                    <div class="card m-2 shadow-sm" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $situacao->nome }}:</h5>
                            <p class="card-text">Total: {{ $situacao->total }}</p>
                            <p>
                                <a href="#">Listar</a>
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="container justify-content-center" style="width: 500px; height: 500px;">
        <canvas id="chartSituacoes"></canvas>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const situacoesLabels = [
                @foreach ($situacoes as $situacao)
                    '{{ $situacao->nome }}',
                @endforeach
            ];

            const situacoesData = [
                @foreach ($situacoes as $situacao)
                    {{ $situacao->total }},
                @endforeach
            ];

            // Cores (pode ajustar ou gerar dinamicamente)
            const situacoesColors = ['#4BC0C0', '#FF6384', '#FFCD56', '#36A2EB'];
        </script>
        <script>
            const data = {
                labels: situacoesLabels,
                datasets: [{
                    label: 'Associados por Situação',
                    data: situacoesData,
                    backgroundColor: situacoesColors,
                }]
            };

            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Status dos Associados'
                        }
                    }
                }
            };

            new Chart(document.getElementById('chartSituacoes'), config);
        </script>
    @endpush


@endsection
