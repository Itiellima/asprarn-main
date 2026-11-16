@extends('layouts.main')

@section('title', 'ASPRARN - Minha Área')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container">

        @include('dashboard.associadoComponents.associado-carteirinha-digital')

        @include('dashboard.associadoComponents.associado-situacao')

        @include('dashboard.associadoPagamentos.listarPagamentos')

        @include('dashboard.associadoComponents.associado-acoes-judiciais')

    </div>
@endsection
