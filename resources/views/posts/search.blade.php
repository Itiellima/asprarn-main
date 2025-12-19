@extends('layouts.main')

@section('title', 'AspraRN - Posts')

@section('content')

<div class="container body-offset">

    {{-- Barra de pesquisa --}}
    <livewire:barra-de-pesquisa />

    @if (request('search'))
        <p class="mt-3">
            Resultados para:
            <strong>{{ request('search') }}</strong>
        </p>
    @endif

    <div class="row mt-4">
        @forelse ($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5>{{ $post->titulo }}</h5>
                        <p>{!! Str::limit(strip_tags($post->texto), 100) !!}</p>

                        <a href="{{ route('posts.show', $post) }}"
                           class="btn btn-primary btn-sm">
                            Ler mais
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p>Nenhum post encontrado.</p>
        @endforelse
    </div>

    {{ $posts->withQueryString()->links() }}
</div>

@endsection
