@extends('layouts.app')

@section('content')
    <div class="container body-offset">

        <div class="container mt-4">
            <h2>{{ $post->titulo }}</h2>
            <p><strong>Assunto:</strong> {{ $post->assunto }}</p>
            <p><strong>Autor:</strong> {{ $post->user->name ?? 'N/A' }}</p>
            <p><strong>Data:</strong> {{ $post->data->format('d/m/Y') }}</p>
            <hr>
            <p>{{ $post->texto }}</p>

            @if ($post->img)
                <img src="{{ asset('storage/' . $post->img) }}" alt="Imagem do post" class="img-fluid mt-3">
            @endif

            <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Voltar</a>
        </div>
    </div>
@endsection
