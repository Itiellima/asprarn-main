@extends('diretoria.components.layout')

@section('diretoria-content')
    <div class="container py-4">

        <div class="text-center mb-5">
            <h2>Diretorias</h2>
            <p class="text-muted">
                Conheça os membros da diretoria da ASPRA-RN
            </p>
            <a href="{{ route('diretoria.membros.create') }}" class="btn btn-sm btn-warning">Novo membro</a>
        </div>

        <p>Total: {{ $membros->count() }}</p>

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

                            <img src="/img/Escudo-pm.png" class="rounded-circle border mb-3"
                                style="width:120px;height:120px;object-fit:cover;" alt="Diretor">

                            <h5>
                                {{ $membro->associado->nome }}
                            </h5>

                            <span class="badge bg-secondary">
                                {{ $membro->funcao->nome ?? 'Sem função' }}
                            </span>

                        </div>

                        <div class="card-footer text-center bg-white">
                            <button class="btn btn-outline-primary btn-sm">
                                Ver Perfil
                            </button>
                            <button class="btn btn-outline-danger btn-sm">
                                Excluir
                            </button>
                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>
@endsection
