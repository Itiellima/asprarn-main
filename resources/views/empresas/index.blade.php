@extends('layouts.main')

@section('title', 'AspraRn - Empresas')

@section('content')

@include('dashboard.layouts.nav-dashboard')

<div class="container">
    <div class="alert alert-light text-black" style="background-color: white;">
        <h3 class="alert-heading text-center">Empresas</h3>
        <p>Bem-vindo à seção de Empresas! Aqui você pode gerenciar as empresas conveniadas,
            visualizar informações e manter os dados atualizados para a ASPRA-RN.</p>
    </div>
</div>

<div class="container">
    <div class="justify-content-center">
        <div class="card mb-3">
            <div class="card-body text-black">
                <h5 class="card-title">Adicionar Empresa</h5>
                <p class="card-text">Clique no botão abaixo para cadastrar uma nova empresa.</p>
                <a href="{{ route('empresas.create') }}" class="btn btn-primary">Adicionar Empresa</a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="justify-content-center">
        <div class="card mb-3">

            <div class="card-body text-black">
                <h5 class="card-title">Lista de Empresas</h5>
                <p class="card-text">Aqui você pode visualizar e gerenciar as empresas cadastradas.</p>
            </div>

            <div class="card-body text-black">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">CNPJ</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Tipo Convênio</th>
                            <th scope="col">Início Contrato</th>
                            <th scope="col">Fim Contrato</th>
                            <th scope="col">Funcionários</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($empresas as $empresa)
                            <tr>
                                <td>{{ $empresa->id }}</td>
                                <td>{{ $empresa->nome }}</td>
                                <td>{{ $empresa->cnpj }}</td>
                                <td>{{ $empresa->telefone }}</td>
                                <td>{{ $empresa->email }}</td>
                                <td>{{ $empresa->tipo_convenio }}</td>
                                <td>{{ $empresa->data_inicio_contrato }}</td>
                                <td>{{ $empresa->data_fim_contrato }}</td>
                                <td>{{ $empresa->funcionarios }}</td>

                                <td>
                                    <a href="{{ route('empresas.show', $empresa->id) }}" class="btn btn-primary">Editar</a>

                                    <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Tem certeza que deseja excluir esta empresa?')">
                                            Excluir
                                        </button>
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