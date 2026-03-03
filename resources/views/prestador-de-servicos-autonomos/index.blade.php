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
                    <a href="" class="btn btn-primary">Adicionar Prestador de Serviço Autônomo</a>
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
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>





@endsection