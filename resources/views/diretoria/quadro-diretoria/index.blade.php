@extends('diretoria.components.layout')

@section('diretoria-content')
    <div class="container py-4">

        <div class="text-center mb-5">
            <h2>Diretorias</h2>
            <p class="text-muted">
                Conheça os membros da diretoria da ASPRA-RN
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-6 col-lg-4">

                <div class="card shadow-sm h-100 border-0 grow">

                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">
                            diretoria
                        </h5>
                    </div>

                    <div class="card-body text-center">

                        <img src="{{ $diretoria->foto ?? '/img/Escudo-pm.png' }}" class="rounded-circle border mb-3"
                            style="width:120px;height:120px;object-fit:cover;" alt="Diretor">

                        <h5>
                            nome
                        </h5>

                        <span class="badge bg-secondary">
                            funcao
                        </span>

                    </div>

                    <div class="card-footer text-center bg-white">
                        <button class="btn btn-outline-primary btn-sm">
                            Ver Perfil
                        </button>
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
