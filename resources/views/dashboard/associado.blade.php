@extends('layouts.main')

@section('title', 'ASPRARN - Minha Área')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container">

        {{-- Aba meus beneficios --}}
        <div class="alert alert-light text-black">
            <h4 class="text-black">Carteirinha digital</h4>
            <div class="row mt-3 mb-3">

                <div class="col-md-6 mb-3 mt-3 d-flex align-items-center justify-content-center">
                    <div class="row d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor"
                            class="bi bi-person-bounding-box" viewBox="0 0 16 16">
                            <path
                                d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5" />
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        </svg>
                        <button class="btn btn-primary mt-3">
                            Editar foto de perfil
                        </button>
                    </div>
                </div>

                <div class="col-md-6">
                    <ul>
                        <li>{{ $associado->nome }}</li>
                        <li>{{ $associado->cpf }}</li>
                        <li>{{ $associado->rg }}</li>
                        <li>{{ $associado->org_expedidor }}</li>
                        <li>Categoria: </li>
                        <li>Plano: </li>

                        <li>Associação dos Praças da Polícia Militar do Rio Grande do Norte (ASPRA PM/RN)</li>
                    </ul>
                </div>
            </div>


            <a href="#" class="mt-3">
                <button class="btn btn-sm btn-primary mb-3">📝 Emitir carteirinha de Associado</button>
            </a>
        </div>

        {{-- Aba meus beneficios --}}
        <div class="alert alert-light">
            <h4 class="text-black">Meus Benefícios</h4>

            <ul>
                <li>Desconto em parceiros comerciais</li>
                <li>Acesso a beneficios exclusivos</li>
            </ul>
            <a href="#">
                <button class="btn btn-primary mb-3">📝 Solicitar Novo Benefício</button>
            </a>
        </div>

        {{-- Aba meus planos --}}
        <div class="alert alert-light">
            <h4 class="text-black">Meu plano</h4>
            <p>Plano Atual: Básico</p>
            <p>Vencimento: Inderteminado</p>
            <a href="#">
                <button class="btn btn-primary mb-3">🔄 Alterar Plano</button>
            </a>
        </div>

        @include('dashboard.associadoComponents.associado-pagamento')




    </div>
@endsection
