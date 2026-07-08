@extends('layouts.main')

@section('title', 'AspraRN - Financeiro')

@section('content')

<style>
    .list-group-item {
        font-weight: bold;
    }
</style>

    <div class="container-fluid ">

        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-3 col-lg-2">

                <div class="border rounded rounded-4 bg-light mb-3">

                    <div class="card-header p-3">
                        <strong>Financeiro</strong>
                    </div>

                    <div class="list-group list-group-flush">

                        <a href="" class="list-group-item list-group-item-action">
                            Extratos
                        </a>

                        <a href="" class="list-group-item list-group-item-action">
                            Lançamentos
                        </a>

                        <a href="{{ route('financeiro.categoria.index') }}" 
                            class="list-group-item list-group-item-action
                            {{ request()->routeIs('financeiro.categoria*') ? 'active' : '' }}">
                            Categorias
                        </a>

                        <a href="{{ route('financeiro.contas_bancarias.index') }}" 
                            class="list-group-item list-group-item-action
                            {{ request()->routeIs('financeiro.contas_bancarias*') ? 'active' : '' }}">
                            Contas Bancárias
                        </a>

                        <a href="{{ route('contas-a-pagar.index') }}" 
                            class="list-group-item list-group-item-action
                            {{ request()->routeIs('contas-a-pagar*') ? 'active' : '' }}">
                            A Pagar
                        </a>

                        <a href="" class="list-group-item list-group-item-action">
                            A Receber
                        </a>

                        <a href="" class="list-group-item list-group-item-action">
                            Relatório por Categoria
                        </a>

                    </div>

                </div>

            </div>

            <!-- CONTEÚDO -->
            <div class="col-md-9 col-lg-10">

                <div class="rounded rounded-4 border bg-light p-3 mb-3">
                    
                    <h3>
                        @yield('financeiro-content-header', 'Financeiro')
                    </h3>

                </div>

                <div class="">

                    @yield('financeiro-content')

                </div>

            </div>

        </div>

    </div>

@endsection
