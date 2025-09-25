@extends('layouts.main')

@section('title', '')

@section('content')

<div class="container body-offset">

    <div class="meu-container mb-3">
        <h1>Clubes de Beneficios</h1>
    </div>
    @auth
        @hasanyrole(['admin', 'moderador'])
            <div>
                <a href="{{ route('beneficio.create') }}" class="btn btn-success">Adicionar beneficio</a>
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
            @foreach ($beneficios as $beneficio)
                <div class="card mx-2 mb-3" style="width: 18rem; min-height: 400px;">
                    <div id="carouselExample{{ $beneficio->id }}" class="carousel slide">
                        <div class="carousel-inner">
                            @foreach ($beneficio->files as $index => $files)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $files->path) }}" class="card-img-top mt-2"
                                        alt="{{ $files->path }}" style="height: 180px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample{{ $beneficio->id }}"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample{{ $beneficio->id }}"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
    
    
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">{{ $beneficio->nome }}</h5>
                            <p class="card-text">{{ $beneficio->descricao }}.</p>
                        </div>
                        <div>
                            <a href="#" class="btn btn-primary">Ver mais</a>
                            @auth
                                @hasanyrole(['admin', 'moderador'])
                                <form action="{{ route('beneficio.destroy', $beneficio->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
    
                                    <button type="submit" class="btn btn-danger ms-2" onclick="return confirm('Tem certeza que deseja excluir esse beneficio?')">Excluir</button>
                                </form>
                                    <a href="{{ route('beneficio.edit', $beneficio->id)}}" class="btn btn-danger m-2">Editar</a>
                                @endhasanyrole
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    
    </div>
    

</div>    



@endsection
