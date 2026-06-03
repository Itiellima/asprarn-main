@extends('layouts.main')

@section('title', 'AspraRN - Financeiro')

@section('content')

    <div class="container-fluid mt-3">

        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-3 col-lg-2">

                <div class="">

                    <div class="card-header">
                        Financeiro
                    </div>

                    <div class="list-group list-group-flush">

                        <a href="" class="list-group-item list-group-item-action">
                            Extratos
                        </a>

                        <a href="" class="list-group-item list-group-item-action">
                            Lançamentos
                        </a>

                        <a href="{{ route('financeiro.categoria') }}" class="list-group-item list-group-item-action">
                            Categorias
                        </a>

                        <a href="" class="list-group-item list-group-item-action">
                            Contas Bancárias
                        </a>

                        <a href="" class="list-group-item list-group-item-action">
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

                <div class="alert alert-light text-left">

                    <h1>Financeiro</h1>

                    <p>Bem-vindo à página de financeiro!</p>

                </div>

                <div class="">

                    @yield('financeiro-content')

                </div>

            </div>

        </div>

    </div>

@endsection
