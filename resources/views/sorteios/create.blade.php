@extends('layouts.main')

@section('title', 'Novo sorteio')

@section('content')

    @include('dashboard.layouts.nav-dashboard')


    <div class="container py-4">


        <div class="card">


            <div class="card-header">
                Novo Sorteio
            </div>


            <div class="card-body">


                <form action="{{ route('sorteios.store') }}" method="POST">

                    @csrf


                    <div class="mb-3">

                        <label>Número</label>

                        <input name="numero" class="form-control" placeholder="Ex: 2026-001">

                    </div>



                    <div class="mb-3">

                        <label>Descrição</label>

                        <input name="descricao" class="form-control">

                    </div>



                    <div class="mb-3">

                        <label>Data</label>

                        <input type="date" name="data_sorteio" class="form-control">

                    </div>



                    {{-- <div class="mb-3">

                        <label>Quantidade de ganhadores</label>

                        <input type="number" name="quantidade_ganhadores" value="1" class="form-control">

                    </div> --}}



                    <button class="btn btn-success">
                        Salvar
                    </button>


                </form>


            </div>


        </div>


    </div>


@endsection
