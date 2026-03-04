@extends('layouts.main')

@section('title', 'AspraRn - Prestador de Serviços Autônomos')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container">
        <div class="alert alert-light text-black" style="background-color: white;">
            <h3 class="alert-heading text-center">Prestadores de Serviços Autônomos</h3>
            <p>Bem-vindo à seção de prestadores de serviços autônomos da ASPRA-RN! Aqui você pode gerenciar os membros da equipe, atribuir funções e garantir
                que todos estejam organizados para o sucesso da ASPRA-RN.</p>
        </div>
    </div>

    <div class="container">
        <div class="justify-content-center">
            <div class="card mb-3">
                <div class="card-body text-black">
                    <h5 class="card-title">Adicionar Prestador de Serviço Autônomo</h5>
                    <p class="card-text">Clique no botão abaixo para adicionar um novo prestador de serviço autônomo à equipe da ASPRA-RN.</p>
                    <a href="{{ route('prestador-de-servicos-autonomos.create') }}" class="btn btn-primary">Adicionar Prestador de Serviço Autônomo</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="justify-content-center">
            <div class="card mb-3">
                <div class="card-body text-black">
                    <h5 class="card-title">Lista de Prestadores de Serviços Autônomos</h5>
                    <p class="card-text">Aqui você pode visualizar e gerenciar os prestadores de serviços autônomos atuais da ASPRA-RN.</p>
                </div>
                <div class="card-body text-black">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Função</th>
                                <th scope="col">Departamento</th>
                                <th scope="col">CPF</th>
                                <th scope="col">Contato</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prestadores as $prestador)
                                <tr>
                                    <th scope="row">{{ $prestador->id }}</th>
                                    <td>{{ $prestador->nome }}</td>
                                    <td>{{ $prestador->funcao }}</td>
                                    <td>{{ $prestador->departamento }}</td>
                                    <td>{{ $prestador->cpf }}</td>
                                    <td>{{ $prestador->telefone_1 }}</td>
                                    <td>
                                        <a href="{{ route('prestador-de-servicos-autonomos.edit', $prestador->id) }}"
                                            class="btn btn-sm btn-warning">Editar</a>

                                        <form action="{{ route('prestador-de-servicos-autonomos.destroy', $prestador->id) }}"
                                            method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Tem certeza que deseja excluir este prestador de serviço autônomo?')">Excluir</button>
                                        </form>
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