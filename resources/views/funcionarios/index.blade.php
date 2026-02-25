@extends('layouts.main')

@section('title', 'AspraRn - Funcionarios')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container">
        <div class="alert alert-light text-black" style="background-color: white;">
            <h3 class="alert-heading text-center">Funcionários</h3>
            <p>Bem-vindo à seção de funcionários! Aqui você pode gerenciar os membros da equipe, atribuir funções e garantir que todos estejam organizados para o sucesso da ASPRA-RN.</p>
        </div>
    </div>

    <div class="container">
        <div class="justify-content-center">
            <div class="card mb-3">
                <div class="card-body text-black">
                    <h5 class="card-title">Adicionar Funcionário</h5>
                    <p class="card-text">Clique no botão abaixo para adicionar um novo funcionário à equipe da ASPRA-RN.</p>
                    <a href="{{ route('funcionarios.create') }}" class="btn btn-primary">Adicionar Funcionário</a>
                </div>
            </div>
        </div>
    </div>





@endsection
