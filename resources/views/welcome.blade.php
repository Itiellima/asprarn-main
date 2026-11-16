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
                    @forelse ($feedPosts as $post)
                        @php
                            // Assunto termina sempre com pontuação, sem duplicar o ponto
                            $assunto = trim((string) $post->assunto);
                            if ($assunto !== '' && !preg_match('/[.!?…]$/u', $assunto)) {
                                $assunto .= '.';
                            }
                        @endphp
                        <div class="container m-3 card grow col-md-11">
                            <div class="row">
                                <div class="col-md-3">
                                    {{-- Post sem imagem mostra o logo, em vez do ícone de imagem quebrada --}}
                                    <img src="{{ $post->files->first()?->url ?? asset('img/Aspra.png') }}"
                                        alt="{{ $post->titulo }}" loading="lazy"
                                        style="height: 10rem; width: 10rem; object-fit: cover;" class="rounded">
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
                                    @if ($assunto !== '')
                                        <p class="card-text">{{ $assunto }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Nenhuma notícia publicada ainda.</p>
                    @endforelse
                </div>

                @if ($feedPosts->isNotEmpty())
                    <div class="text-center mb-4">
                        <a href="{{ route('search') }}" class="btn btn-outline-primary">Ver todas as notícias</a>
                    </div>
                @endif
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

                            {{-- Do 7º ao 9º post: os 6 primeiros já estão em "Notícias" --}}
                            <h4 class="fst-italic">Mais notícias</h4>
                            <ul class="list-unstyled">
                                @foreach ($recentPosts as $post)
                                    <li>
                                        <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top"
                                            href="{{ route('posts.show', $post->id) }}">

                                            @if ($post->files->isNotEmpty())
                                                <img src="{{ $post->files->first()->url }}"
                                                    alt="{{ $post->titulo }}" width="100" height="100" loading="lazy"
                                                    style="object-fit: cover;">
                                            @endif

                                            <div class="col-lg-8">
                                                <h6 class="mb-0">{{ $post->titulo }}</h6>
                                                @if ($post->data)
                                                    <small class="text-body-secondary">{{ $post->data->format('d/m/Y') }}</small>
                                                @endif
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
