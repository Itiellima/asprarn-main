@extends('layouts.main')

@section('title', 'AspraRN - ' . $post->titulo)

@section('content')
    <div class="container body-offset">

        <div class="container mt-4">
            <h2>{{ $post->titulo }}</h2>
            <p><strong>Assunto:</strong> {{ $post->assunto }}</p>
            <p><strong>Autor:</strong> {{ $post->user->name ?? 'N/A' }}</p>
            <p><strong>Data:</strong> {{ $post->data->format('d/m/Y') }}</p>
            <hr>
            <p>{!! $post->texto !!}</p>

            <div class="row justify-content-center">
                @if ($post->files->isNotEmpty())
                    @foreach ($post->files as $file)
                        <img src="{{ asset('storage/' . $file->path) }}" class="card-img-top"
                            style="height: 400px; width: auto; object-fit: cover;" alt="{{ $post->titulo }}">
                    @endforeach
                @endif
            </div>
            <br>
            <a href="/" class="btn btn-secondary mt-3">Voltar</a>
        </div>
    </div>
@endsection
