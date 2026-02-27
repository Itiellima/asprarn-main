@extends('layouts.main')

@section('title', 'AspraRn - Funcionarios')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container">
        <div class="alert alert-light text-black" style="background-color: white;">
            <h3 class="alert-heading text-center">Funcionários</h3>
            <p>Bem-vindo à seção de funcionários! Aqui você pode gerenciar os membros da equipe, atribuir funções e garantir
                que todos estejam organizados para o sucesso da ASPRA-RN.</p>
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
    <div class="container">
        <div class="justify-content-center">
            <div class="card mb-3">
                <div class="card-body text-black">
                    <h5 class="card-title">Lista de Funcionários</h5>
                    <p class="card-text">Aqui você pode visualizar e gerenciar os funcionários atuais da ASPRA-RN.</p>
                </div>
                <div class="card-body text-black">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nome</th>
                                <th scope="col">CPF</th>
                                <th scope="col">Contato</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($funcionarios as $funcionario)
                                <tr>
                                    <td>{{ $funcionario->id }}</td>
                                    <td>{{ $funcionario->nome }}</td>
                                    <td>{{ $funcionario->cpf }}</td>
                                    <td>{{ $funcionario->telefone_1 }}</td>
                                    <td>
                                        <button class="btn btn-primary">Ver mais</button>
                                        <button class="btn btn-danger">Excluir</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>





@endsection
