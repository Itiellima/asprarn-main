@extends('layouts.main')

@section('title', 'Aspra Associado')

@section('content')

@include('dashboard.layouts.nav-dashboard')

    <div class="container border rounded-3 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
            <h1>Configurações</h1>
        </div>

        <p>Aqui você pode gerenciar as configurações do sistema.</p>

        {{-- Adicione mais conteúdo relacionado às configurações aqui --}}

        @include('configuracoes.components.situacao-controller')










    </div>
@endsection