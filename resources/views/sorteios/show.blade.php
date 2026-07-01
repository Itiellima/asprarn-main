@extends('layouts.main')

@section('title', 'ASPRA-RN - Sorteio')

@section('content')

    @include('dashboard.layouts.nav-dashboard')


    <div class="container py-4">


        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3>
                    Sorteio Nº {{ $sorteio->numero }}
                </h3>

                <p class="text-muted mb-0">
                    {{ $sorteio->descricao }}
                </p>
            </div>


            <span class="badge 
            {{ $sorteio->status == 'ativo' ? 'bg-success' : 'bg-secondary' }}">

                {{ ucfirst($sorteio->status) }}

            </span>

        </div>



        <div class="row g-4">



            {{-- PARTICIPANTES --}}
            <div class="col-md-6">


                <div class="card shadow-sm">


                    <div class="card-header d-flex justify-content-between">

                        Participantes

                        <span class="badge bg-primary">
                            {{ $sorteio->participantes->count() }}
                        </span>

                    </div>



                    <div class="card-body">


                        @forelse($sorteio->participantes as $participante)
                            <div class="border rounded p-2 mb-2 d-flex justify-content-between">


                                <div>

                                    <strong>
                                        {{ $participante->nome }}
                                    </strong>

                                    <br>

                                    <small>
                                        {{ $participante->cpf }}
                                    </small>

                                </div>



                                @if ($participante->associado_id)
                                    <span class="badge bg-success">
                                        Associado
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Visitante
                                    </span>
                                @endif


                            </div>


                        @empty

                            <p class="text-muted">
                                Nenhum participante.
                            </p>
                        @endforelse


                    </div>


                </div>


            </div>





            {{-- RESULTADO --}}
            <div class="col-md-6">


                <div class="card shadow-sm">


                    <div class="card-header">

                        Resultado

                    </div>


                    <div class="card-body">



                        @forelse($resultados as $resultado)
                            <div class="alert alert-success">


                                <h5>

                                    🏆 {{ $resultado->posicao }}º lugar

                                </h5>


                                <strong>

                                    {{ $resultado->participante?->nome }}

                                </strong>


                                <br>


                                @if ($resultado->premio)
                                    <small>
                                        {{ $resultado->premio }}
                                    </small>
                                @endif


                            </div>



                        @empty


                            <p class="text-muted">
                                Sorteio ainda não realizado.
                            </p>
                        @endforelse



                    </div>


                </div>


            </div>



        </div>




        {{-- AÇÕES --}}

        @if ($sorteio->status == 'ativo')
            <div class="card mt-4 shadow-sm">


                <div class="card-header">

                    Adicionar participante

                </div>


                <div class="card-body">


                    <form action="{{ route('sorteios.participante.store', $sorteio->id) }}" method="POST">


                        @csrf


                        <div class="row">


                            <div class="col-md-5">

                                <input name="nome" class="form-control" placeholder="Nome" autofocus>

                            </div>



                            <div class="col-md-4">

                                <input name="cpf" class="form-control" placeholder="CPF">

                            </div>



                            <div class="col-md-3">

                                <button class="btn btn-primary w-100">

                                    Adicionar

                                </button>

                            </div>


                        </div>


                    </form>



                </div>


            </div>




            <form action="{{ route('sorteios.sortear', $sorteio->id) }}" method="POST" class="mt-3 text-end">

                @csrf


                <button class="btn btn-warning" onclick="return confirm('Realizar sorteio?')">

                    🎲 Realizar sorteio

                </button>


            </form>
        @endif




    </div>


@endsection
