@extends('layouts.main')

@section('title', 'ASPRARN - Clubes de Benefícios')

@section('content')

    <div class="container body-offset">

        <div class="meu-container mb-3">
            <h1 style="color: #0a499c; font-size: 3rem; text-;">Clubes de Beneficios</h1>
        </div>
        @auth
            @hasanyrole(['admin', 'moderador'])
                <div class="m-3">
                    <a href="{{ route('beneficio.create') }}" class="btn btn-success">Adicionar benefício</a>
                    <a href="{{ route('beneficio.order') }}" class="btn btn-secondary">Altere a ordem dos benefícios</a>
                </div>
            @endhasanyrole
        @endauth


        <div class="meu-container row">

            @if ($beneficios->isEmpty())
                <div class="card mx-2 mb-3 col-6" style="width: 18rem;">
                    <img src="/img/Aspra.png" class="card-img-top" alt="aspra">
                    <div class="card-body">
                        <h5 class="card-title">ASSISTÊNCIA FUNERÁRIA</h5>
                        <p class="card-text">Cobertura de assistência funerária.</p>
                        <a href="#" class="btn btn-primary">Ver mais</a>
                        @auth
                            @hasanyrole(['admin', 'moderador'])
                                <a href="" class="btn btn-danger ms-2">Excluir</a>
                            @endhasanyrole
                        @endauth
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach ($beneficios as $beneficio)
                        <div class="col-sm-12 col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-duration="1000">
                            {{-- CARD BENEFICIO --}}
                            
                            <div class="card h-100 shadow">

                                {{-- CARROSSEL --}}
                                <div id="carouselExample{{ $beneficio->id }}" class="carousel slide">

                                    {{-- IMGAGENS DO BENEFICIO --}}
                                    <div class="carousel-inner" style="min-height: 200px;">
                                        @foreach ($beneficio->files as $index => $files)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $files->path) }}" class="card-img-top mt-2"
                                                    alt="{{ $files->path }}"
                                                    style="height: 200px; width: 100%; object-fit: contain;">
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- BOTOES PARA PASSAR AS IMGAGENS --}}
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExample{{ $beneficio->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExample{{ $beneficio->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>

                                </div>

                                {{-- TITULO E DESCRIÇÃO --}}
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="card-title" style="text-align: center">
                                            {{ $beneficio->nome }}
                                        </h5>
                                        <p class="card-text" style="text-align: justify">
                                            {{ $beneficio->descricao }}
                                        </p>
                                    </div>
                                    <div>
                                        {{-- <a href="#" class="btn btn-primary">Ver mais</a> --}}
                                        @auth
                                            @hasanyrole(['admin', 'moderador'])
                                                <form action="{{ route('beneficio.destroy', $beneficio->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger ms-2"
                                                        onclick="return confirm('Tem certeza que deseja excluir esse beneficio?')">Excluir</button>
                                                </form>
                                                <a href="{{ route('beneficio.edit', $beneficio->id) }}"
                                                    class="btn btn-danger m-2">Editar</a>
                                            @endhasanyrole
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>


    </div>



@endsection
