@extends('diretoria.components.layout')

@section('diretoria-content')
    <div class="container py-4">

        {{-- Cabeçalho --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="mb-1">Membros</h2>
                <p class="text-muted mb-0">
                    Conheça e gerencie os membros da diretoria da ASPRA-RN.
                </p>
            </div>

            <a href="{{ route('diretoria.membros.create') }}" class="btn btn-warning">
                <i class="bi bi-person-plus me-1"></i>
                Novo membro
            </a>
        </div>

        {{-- Lista de membros --}}
        <div class="row g-4">

            @forelse ($membros as $membro)
                <div class="col-sm-6 col-lg-4">

                    <div class="card h-100 border-0 shadow-sm">

                        {{-- Diretoria --}}
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h6 class="mb-0 fw-semibold">
                                {{ $membro->diretoria->nome ?? 'Sem diretoria' }}
                            </h6>
                        </div>

                        {{-- Conteúdo --}}
                        <div class="card-body text-center p-4">

                            {{-- Foto --}}
                            @if ($membro->associado->pictureProfile?->path)
                                <img src="{{ asset('storage/' . $membro->associado->pictureProfile->path) }}"
                                    alt="Foto de {{ $membro->associado->nome }}"
                                    class="rounded-circle border shadow-sm mb-3"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <img src="{{ asset('img/Escudo-pm.png') }}" alt="Foto não disponível"
                                    class="rounded-circle border shadow-sm mb-3"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            @endif

                            {{-- Nome --}}
                            <h5 class="fw-semibold mb-2">
                                {{ $membro->associado->nome }}
                            </h5>

                            {{-- Função --}}
                            @if ($membro->funcao)
                                <span class="badge bg-secondary px-3 py-2">
                                    {{ $membro->funcao->nome }}
                                </span>
                            @else
                                <span class="badge bg-light text-secondary border px-3 py-2">
                                    Sem função
                                </span>
                            @endif

                        </div>

                        {{-- Ações --}}
                        <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">

                            <div class="d-flex gap-2">

                                <a href="{{ route('diretoria.membros.edit', $membro->id) }}"
                                    class="btn btn-outline-warning btn-sm flex-fill">
                                    <i class="bi bi-pencil me-1"></i>
                                    Editar
                                </a>

                                <form action="{{ route('diretoria.membros.destroy', $membro->id) }}" method="POST"
                                    class="flex-fill">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                        onclick="return confirm('Deseja excluir o membro {{ $membro->associado->nome }} da diretoria?');">
                                        <i class="bi bi-trash me-1"></i>
                                        Excluir
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                {{-- Estado vazio --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">

                            <i class="bi bi-people fs-1 text-muted"></i>

                            <h5 class="mt-3">
                                Nenhum membro cadastrado
                            </h5>

                            <p class="text-muted mb-3">
                                Ainda não existem membros cadastrados na diretoria.
                            </p>

                            <a href="{{ route('diretoria.membros.create') }}" class="btn btn-warning">
                                <i class="bi bi-person-plus me-1"></i>
                                Cadastrar primeiro membro
                            </a>

                        </div>
                    </div>
                </div>
            @endforelse

        </div>

    </div>
@endsection
