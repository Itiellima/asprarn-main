@extends('layouts.main')

@section('title', 'AspraRN - Bem vindo')

@section('content')

    {{-- BANNERS --}}
    @include('welcome-components.banner')

    <div class="container body-offset">
        <div class="row mt-3">
            <div class="col-md-8">
                <h2>NOTICIAS</h2>
                <hr>
                <div class="row">
                    @foreach ($recentPosts as $post)
                        <div class="card m-1 rounded-5 overflow-hidden p-0 shadow-lg col-sm-6" style="width: 20rem;">

                            <img src="{{ asset('storage/' . $post->files->first()->path) }}" class="card-img-top"
                                style="height: 200px; width: 100%; object-fit: cover;" alt="{{ $post->titulo }}">

                            <div class="card-body">
                                <h5 class="card-title">{{ $post->titulo }}</h5>
                                <p class="card-text">{{ $post->assunto }}.</p>
                            </div>
                            <div class="mb-3">
                                <a href="/posts/{{ $post->id }}">leia mais</a>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="col-md-4">
                <div class="position-sticky" style="top: 6rem;">
                    <div class="p-4 mb-3 bg-body-tertiary rounded">
                        <h3 class="fst-italic">Sobre a ASPRA</h3>
                        <p class="mb-0">Saiba sobre nossa associação, nossos convênios e seus benefícios.
                            <a href="{{ route('beneficio.index') }}">Acesse Aqui!</a>
                        </p>
                    </div>

                    <div>
                        @if ($recentPosts->isNotEmpty())

                            <h4 class="fst-italic">Ultimos posts</h4>
                            <ul class="list-unstyled">
                                @foreach ($recentPosts as $post)
                                    <li>
                                        <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top"
                                            href="#">

                                            @if ($post->files->isNotEmpty())
                                                <img src="{{ asset('storage/' . $post->files->first()->path) }}"
                                                    alt="{{ $post->titulo }}" width="100" height="100">
                                            @endif

                                            <div class="col-lg-8">
                                                <h6 class="mb-0">{{ $post->titulo }}</h6> <small
                                                    class="text-body-secondary">{{ $post->data->format('d/m/Y') }}</small>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>

    @livewire('instagram-post')

@endsection
