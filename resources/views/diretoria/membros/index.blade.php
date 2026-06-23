@extends('diretoria.components.layout')

@section('diretoria-content')
    <div class="container py-4">

        <div class="text-center mb-5">
            <h2>Membros</h2>
            <p class="text-muted">
                Conheça os membros da diretoria da ASPRA-RN
            </p>
            <a href="{{ route('diretoria.membros.create') }}" class="btn btn-sm btn-warning">Novo membro</a>
        </div>

        <div class="row g-4">

            @foreach ($membros as $membro)
                <div class="col-md-6 col-lg-4">

                    <div class="card shadow-sm h-100 border-0 grow">

                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="mb-0">
                                {{ $membro->diretoria->nome ?? 'Sem diretoria' }}
                            </h5>
                        </div>

                        <div class="card-body text-center">

                            @if ($membro->associado->pictureProfile?->path)
                                <img src="{{ asset('storage/' . $membro->associado->pictureProfile->path) }}"
                                    style="width:120px;height:120px;object-fit:cover;" alt="Diretor"
                                    class="rounded-circle border mb-3">
                            @else
                                <img src="/img/Escudo-pm.png" class="rounded-circle border mb-3"
                                    style="width:120px;height:120px;object-fit:cover;" alt="Diretor">
                            @endif



                            <h5>
                                {{ $membro->associado->nome }}
                            </h5>

                            <span class="badge bg-secondary">
                                {{ $membro->funcao->nome ?? 'Sem função' }}
                            </span>

                        </div>

                        <div class="card-footer text-center bg-white">
                            <a href="{{ route('diretoria.membros.edit', $membro->id) }}"
                                class="btn btn-outline-primary btn-sm">
                                Editar
                            </a>
                            <form action="{{ route('diretoria.membros.destroy', $membro->id) }}" method="POST"
                                style="display:inline;"
                                onclick="return confirm('Deseja excluir esse membro? {{ $membro->associado->nome }}?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    Excluir
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>
@endsection
