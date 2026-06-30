@extends('layouts.main')

@section('title', 'ASPRA-RN - Sorteios')

@section('content')

    @include('dashboard.layouts.nav-dashboard')


    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3>Sorteios</h3>
                <p class="text-muted">
                    Gerenciamento de sorteios e participantes
                </p>
            </div>


            <a href="{{ route('sorteios.create') }}" class="btn btn-primary">
                Novo sorteio
            </a>

        </div>



        <div class="row g-4">


            @forelse($sorteios as $sorteio)
                <div class="col-md-4">


                    <div class="card shadow-sm h-100">


                        <div class="card-header bg-primary text-white">

                            Sorteio Nº {{ $sorteio->numero }}

                        </div>


                        <div class="card-body">


                            <h5>
                                {{ $sorteio->descricao }}
                            </h5>


                            <p>
                                Data:
                                {{ \Carbon\Carbon::parse($sorteio->data_sorteio)->format('d/m/Y') }}
                            </p>


                            <span
                                class="badge 
                        {{ $sorteio->status == 'ativo' ? 'bg-success' : 'bg-secondary' }}">

                                {{ ucfirst($sorteio->status) }}

                            </span>


                        </div>


                        <div class="card-footer text-end">


                            <a href="{{ route('sorteios.show', $sorteio->id) }}" class="btn btn-sm btn-outline-primary">

                                Abrir

                            </a>


                        </div>


                    </div>


                </div>


            @empty


                <div class="alert alert-info">
                    Nenhum sorteio cadastrado.
                </div>
            @endforelse


        </div>


    </div>


@endsection
