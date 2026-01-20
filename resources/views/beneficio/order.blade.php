@extends('layouts.main')

@section('title', 'ASPRARN - Clubes de Benefícios')

@section('content')

    <div class="container body-offset">

        <div class="meu-container mb-3">
            <h1 style="color: #0a499c; font-size: 3rem;">Clubes de Benefícios</h1>
        </div>

        @auth
            @hasanyrole(['admin', 'moderador'])
                <div class="m-3">
                    <a href="{{ route('beneficio.create') }}" class="btn btn-success">Adicionar benefício</a>
                </div>
            @endhasanyrole
        @endauth

        @if ($beneficios->isEmpty())
            <div class="container">
                <p>Nenhum benefício cadastrado.</p>
            </div>
        @else
            {{-- Form para salvar a ordem --}}
            <form method="POST" action="">
                @csrf

                {{-- Container único para o SortableJS --}}
                <div id="grid" class="row meu-container">

                    @foreach ($beneficios as $beneficio)
                        <div class="col-sm-12 col-md-6 col-lg-4 mb-4 card-beneficio" data-id="{{ $beneficio->id }}">
                            {{-- CARD BENEFICIO --}}
                            <div class="card h-100 shadow">

                                {{-- CARROSSEL --}}
                                <div id="carouselExample{{ $beneficio->id }}" class="carousel slide">

                                    <div class="carousel-inner" style="min-height: 200px;">
                                        @foreach ($beneficio->files as $index => $files)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $files->path) }}" class="card-img-top mt-2"
                                                    alt="{{ $files->path }}"
                                                    style="height: 200px; width: 100%; object-fit: contain;">
                                            </div>
                                        @endforeach
                                    </div>

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
                                        <h5 class="card-title text-center">{{ $beneficio->nome }}</h5>
                                        <p class="card-text" style="text-align: justify;">{{ $beneficio->descricao }}</p>
                                    </div>
                                    <div>
                                        @auth
                                            @hasanyrole(['admin', 'moderador'])
                                                <form action="{{ route('beneficio.destroy', $beneficio->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger ms-2"
                                                        onclick="return confirm('Tem certeza que deseja excluir esse benefício?')">Excluir</button>
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

                {{-- Inputs ocultos --}}
                <div id="inputs-ordem"></div>

                {{-- Botão salvar --}}
                @auth
                    @hasanyrole('admin|moderador')
                        <button type="submit" class="btn btn-primary mt-3">Salvar ordem</button>
                    @endhasanyrole
                @endauth
            </form>
        @endif

    </div>

    {{-- Scripts SortableJS --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        const grid = document.getElementById('grid');
        const form = document.querySelector('form');
        const inputsOrdem = document.getElementById('inputs-ordem');

        // Inicializa o SortableJS
        new Sortable(grid, {
            animation: 150
        });

        // Ao enviar o form, preenche os inputs hidden com a ordem atual
        form.addEventListener('submit', function() {
            inputsOrdem.innerHTML = '';

            [...grid.children].forEach(el => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ordem[]';
                input.value = el.dataset.id;
                inputsOrdem.appendChild(input);
            });
        });
    </script>

@endsection
