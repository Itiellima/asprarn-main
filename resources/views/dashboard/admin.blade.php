@extends('layouts.main')

@section('title', 'AspraRN - Dashboard')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    {{-- <div class="container text-center alert alert-light">
        <h2>Visao Geral</h2>
    </div>
    <div class="container text-center">
        <div class="row flex m-3 justify-content-center">
            <div class="card m-2 shadow-sm" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Associados cadastrados:</h5>
                    <p class="card-text">Total: {{ $totalAssociados }}</p>
                    <p>
                        <a href="{{ route('associado.index') }}">Listar</a>
                    </p>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="container text-center">
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
    </div> --}}

    {{-- @include('dashboard.adminComponents.doughnut-situacoes')

    @include('dashboard.adminComponents.verticalBar-cadastrosPorMes') --}}

    <div id="dashboardCollapse">

        <div class="d-flex gap-2 mb-3 justify-content-center">
            <button id="btnSituacoes" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseSituacoes">
                📊 Situação dos Associados
            </button>

            <button id="btnMes" class="btn btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#collapseMes">
                📈 Associados cadastrados por Mês
            </button>
        </div>

        <div id="collapseSituacoes" class="collapse show" data-bs-parent="#dashboardCollapse">
            @include('dashboard.adminComponents.doughnut-situacoes')
        </div>

        <div id="collapseMes" class="collapse" data-bs-parent="#dashboardCollapse">
            @include('dashboard.adminComponents.verticalBar-cadastrosPorMes')
        </div>

    </div>

    <script>
        const btnSituacoes = document.getElementById('btnSituacoes');
        const btnMes = document.getElementById('btnMes');

        const collapseSituacoes = document.getElementById('collapseSituacoes');
        const collapseMes = document.getElementById('collapseMes');

        collapseSituacoes.addEventListener('show.bs.collapse', () => {
            btnSituacoes.classList.add('btn-primary');
            btnSituacoes.classList.remove('btn-outline-primary');

            btnMes.classList.add('btn-outline-primary');
            btnMes.classList.remove('btn-primary');
        });

        collapseMes.addEventListener('show.bs.collapse', () => {
            btnMes.classList.add('btn-primary');
            btnMes.classList.remove('btn-outline-primary');

            btnSituacoes.classList.add('btn-outline-primary');
            btnSituacoes.classList.remove('btn-primary');
        });
    </script>

@endsection
