@extends('layouts.main')

@section('title', 'AspraRN - Bem vindo')

@section('content')


    <livewire:barra-de-pesquisa />


    {{-- BANNERS --}}
    @include('welcome-components.banner')

    @livewire('instagram-post')



    <div class="container body-offset">
        <div class="row mt-3">
            <div class="col-md-8">
                <h2>NOTÍCIAS</h2>
                <hr>
                <div class="row justify-content-center">
                    @foreach ($feedPosts as $post)
                        <div class="container m-3 card grow col-md-11">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{ asset('storage/' . $post->files->first()->path) }}" alt="{{ $post->titulo }}"
                                        style="height: 10rem; width: 10rem;" class="rounded">
                                </div>
                                <div class="col-md-8 mt-3">
                                    <strong>
                                        <p>
                                            <a href="{{ route('posts.show', $post->id) }}" style="font-size: large"
                                                class="link-dark link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover
                                                icon-link icon-link-hover">
                                                {{ $post->titulo }}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="bi" viewBox="0 0 16 16"
                                                    aria-hidden="true">
                                                    <path
                                                        d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                                </svg>
                                            </a>
                                        </p>
                                    </strong>
                                    <p class="card-text">{{ $post->assunto }}.</p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card m-3 rounded-5 overflow-hidden p-0 shadow-lg col-sm-6" style="width: 18rem;">

                            <div class="card-head">
                                <img src="{{ asset('storage/' . $post->files->first()->path) }}" class="card-img-top"
                                    style="height: 200px; width: 100%; object-fit: cover;" alt="{{ $post->titulo }}">
                            </div>

                            <div class="card-body">
                                <a href="{{ route('posts.show', $post->id) }}"
                                    style="font-size: large"
                                    class="link-dark link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover">
                                    {{ $post->titulo }}
                                </a>
                                <hr>

                                <p class="card-text">{{ $post->assunto }}.</p>
                            </div>
                            <div class="card-footer">
                                <a class="btn btn-sm btn-secondary" href="/posts/{{ $post->id }}">Leia mais</a>
                            </div>
                        </div> --}}
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
                                            href="/posts/{{ $post->id }}">

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

@endsection
