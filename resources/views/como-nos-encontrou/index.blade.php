@extends('layouts.main')

@section('title', 'Como nos encontrou?')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container text-center mt-4">
        <h1>Como nos encontrou?</h1>
    </div>
    <div class="container">
        @foreach ($comoNosEncontrou as $data)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $data->nome }}</h5>
                    <p class="card-text"><strong>Descrição:</strong> {{ $data->descricao }}</p>
                    <p class="card-text"><strong>Indicação:</strong> {{ $data->indicacao }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="container mt-4">
        {{ $comoNosEncontrou->links() }}
    </div>



@endsection
