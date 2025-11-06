@extends('layouts.main')

@section('title', 'Aspra Associado')

@section('content')
    @include('dashboard.layouts.nav-dashboard')

    <div class="container">

        <div class=" display-flex row justify-content align-center alert alert-light m-3 text-center">
            <h1 class="text-black">
                <strong>
                    Planos
                </strong>
            </h1>
            <hr>
            <h2>Informações sobre os planos</h2>
        </div>

        <div class="content-flex row content-center items-center align-center m-3">
                <a class="btn btn-primary" href="{{ route('planos.create') }}">Novo plano</a>
        </div>

        @include('planos.card-all-planos')

    </div>

@endsection
