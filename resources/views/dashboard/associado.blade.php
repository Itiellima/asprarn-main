@extends('layouts.main')

@section('title', 'ASPRARN - Minha Área')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container">

        @include('dashboard.associadoComponents.associado-carteirinha-digital')

        {{-- Aba meus beneficios --}}
        {{-- <div class="alert alert-light">
            <h4 class="text-black">Meus Benefícios</h4>

            <ul>
                <li>Desconto em parceiros comerciais</li>
                <li>Acesso a beneficios exclusivos</li>
            </ul>
            <a href="#">
                <button class="btn btn-primary mb-3">📝 Solicitar Novo Benefício</button>
            </a>
        </div> --}}

        {{-- @include('dashboard.associadoComponents.associado-planos') --}}

        {{-- @include('dashboard.associadoComponents.associado-pagamento') --}}




    </div>
@endsection
