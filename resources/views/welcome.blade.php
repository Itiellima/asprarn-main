@extends('layouts.main')

@section('title', '')

@section('content')
    <div class="container body-offset">

        @if ($latestPost)
            <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
                <div class="row align-items-center">
                    <div class="col-lg-7 px-0">
                        <h2 class="display-4 fst-italic">{{ $latestPost->titulo }}</h2>
                        <p class="lead my-3">{{ $latestPost->assunto }}</p>
                        <p class="lead mb-0"><a href="#" class="text-body-emphasis fw-bold">Continue lendo...</a></p>
                    </div>
                    <div class="col-lg-5 px-0">
                        <div id="carouselExample" class="carousel slide">
                            @if ($latestPost->files->isNotEmpty())
                                <div class="carousel-inner">
                                    @foreach ($latestPost->files as $index => $file)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $file->path) }}" class="img-fluid"
                                                alt="{{ $latestPost->titulo }}">
                                        </div>
                                    @endforeach
                                </div>

                            @endif

                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        @else
            <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
                <div class="row align-items-center">
                    <div class="col-lg-7 px-0">
                        <h2 class="display-4 fst-italic">Associação de Praças da Policia Militar do RN.</h2>
                        <p class="lead my-3"> Fique por dentro de todas as novidades.
                        </p>
                        {{-- <p class="lead mb-0"><a href="#" class="text-body-emphasis fw-bold">Continue lendo...</a></p> --}}
                    </div>
                    <div class="col-lg-5 px-0">
                        <img src="/img/Aspra.png" class="card-img-top" alt="aspra">
                    </div>
                </div>
            </div>
        @endif


        <div class="row g-5">
            <div class="col-md-8">
                {{-- <h3 class="pb-4 mb-4 fst-italic border-bottom">
                From the Firehose
            </h3> --}}
                @if ($recentPosts->isNotEmpty())
                    @foreach ($recentPosts as $post)
                        <article class="blog-post">
                            <h2 class="display-5 link-body-emphasis mb-1">
                                {{ $post->titulo }}
                            </h2>
                            <p class="blog-post-meta">Atualizado em
                                {{ $post->updated_at->format('d/m/Y') }} incluido por:<a href="#">
                                    {{ $post->owner }}</a></p>
                            <p>
                                {!! $post->texto !!}
                            </p>
                        </article>
                    @endforeach
                @else
                    <article class="blog-post">
                        <h2 class="display-5 link-body-emphasis mb-1">ASPRA RN</h2>
                        <p class="blog-post-meta">January 1, 2021 by <a href="#">Mark</a></p>
                        <p> ASPRA RN (Associação dos Praças do Rio Grande do Norte) é uma entidade que representa militares de praças
                             em diversos estados brasileiros, oferecendo suporte jurídico e outras assistências. 
                        </p>
                        <hr>
                        
                @endif

                {{-- <nav class="blog-pagination" aria-label="Pagination">
                    <a class="btn btn-outline-primary rounded-pill" href="#">Older</a>
                    <a class="btn btn-outline-secondary rounded-pill disabled" aria-disabled="true">Newer</a>
                </nav> --}}


            </div>
            <div class="col-md-4">
                <div class="position-sticky" style="top: 6rem;">
                    <div class="p-4 mb-3 bg-body-tertiary rounded">
                        <h3 class="fst-italic">Sobre a ASPRA</h3>
                        <p class="mb-0">Saiba sobre nossa associação, nossos convênios e seus benefícios.
                            <a href="#">Acesse Aqui!</a>
                        </p>
                    </div>

                    <div>
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
                    </div>

                    <div class="p-4">
                        <h4 class="fst-italic">Archives</h4>
                        <ol class="list-unstyled mb-0">
                            <li><a href="#">March 2021</a></li>
                            <li><a href="#">February 2021</a></li>
                            <li><a href="#">January 2021</a></li>
                            <li><a href="#">December 2020</a></li>
                            <li><a href="#">November 2020</a></li>
                            <li><a href="#">October 2020</a></li>
                            <li><a href="#">September 2020</a></li>
                            <li><a href="#">August 2020</a></li>
                            <li><a href="#">July 2020</a></li>
                            <li><a href="#">June 2020</a></li>
                            <li><a href="#">May 2020</a></li>
                            <li><a href="#">April 2020</a></li>
                        </ol>
                    </div>
                    <div class="p-4">
                        <h4 class="fst-italic">Redes Sociais</h4>
                        <ol class="list-unstyled">
                            <li><a href="#">GitHub</a></li>
                            <li><a href="#">Social</a></li>
                            <li><a href="#">Facebook</a></li>
                            <li><a href="https://www.instagram.com/associacaosdospracas/" target="_blank">Instagram</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>


            {{-- <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
                <div class="col-lg-6 px-0">
                    <h1 class="display-4 fst-italic">Title of a longer featured blog post</h1>
                    <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and
                        efficiently about what’s most interesting in this post’s contents.</p>
                    <p class="lead mb-0"><a href="#" class="text-body-emphasis fw-bold">Continue reading...</a></p>
                </div>
            </div>
            <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
                <div class="col-lg-6 px-0">
                    <h1 class="display-4 fst-italic">Title of a longer featured blog post</h1>
                    <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and
                        efficiently about what’s most interesting in this post’s contents.</p>
                    <p class="lead mb-0"><a href="#" class="text-body-emphasis fw-bold">Continue reading...</a></p>
                </div>
            </div>
            <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
                <div class="col-lg-6 px-0">
                    <h1 class="display-4 fst-italic">Title of a longer featured blog post</h1>
                    <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and
                        efficiently about what’s most interesting in this post’s contents.</p>
                    <p class="lead mb-0"><a href="#" class="text-body-emphasis fw-bold">Continue reading...</a></p>
                </div>
            </div> --}}

        </div>

        <p>
        <h1>
            Bem-vindo a Aspra
        </h1>
        </p>
        <p>
        <h2>
            Associação dos Praças da Polícia Militar e Corpo de Bombeiros Militar do Estado do Rio Grande do Norte
        </h2>
        </p>
    </div>





@endsection
