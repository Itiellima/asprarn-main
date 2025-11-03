@extends('layouts.main')

@section('title', 'ASPRARN - Minha Área')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container">


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

        @include('dashboard.layouts.associado-pagamento')




    </div>
@endsection
