@extends('layouts.main')

@section('title', '')

@section('content')


    @include('layouts.nav-dashboard')

    <div class="container text-center alert alert-light">
        <h2>Visao Geral</h2>
    </div>
    <div class="meu-container">
        <div class="row m-3">
            <div class="card m-2" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Associados cadastrados:</h5>
                    <p class="card-text">Total: {{ count($associados) }}</p>
                    <p>
                        <a href="#">Listar</a>
                    </p>
                </div>
            </div>

            <div class="card m-2" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Associados ativos:
                    </h5>
                    <p class="card-text">Total: {{ $associados->where('situacao.ativo', true)->count() }}</p>
                    <p>
                        <a href="#">Listar</a>
                    </p>
                </div>
            </div>

            <div class="card m-2" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Associados inadimplentes:</h5>
                    <p class="card-text">Total: {{ $associados->where('situacao.inadimplente', true)->count() }}</p>
                    <p>
                        <a href="#">Listar</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="meu-container">
        <div class="row m-3">
            <div class="card m-2" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Pendente financeiro:</h5>
                    <p class="card-text">Total: {{ $associados->where('situacao.pendente_financeiro', true)->count() }}</p>
                    <p>
                        <a href="#">Listar</a>
                    </p>
                </div>
            </div>

            <div class="card m-2" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Pendente documentação:</h5>
                    <p class="card-text">Total: {{ $associados->where('situacao.pendente_documento', true)->count() }}</p>
                    <p>
                        <a href="#">Listar</a>
                    </p>
                </div>
            </div>

        </div>
    </div>

@endsection
