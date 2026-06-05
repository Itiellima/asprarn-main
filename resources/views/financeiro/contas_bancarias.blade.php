@extends('financeiro.components.layout')

@section('financeiro-content-header')
    Contas Bancárias
@endsection

@section('financeiro-content')


    <div class="container rounded">
        <a href="{{ route('financeiro.contas_bancarias.create') }}" class="btn btn-primary">
            Nova Conta Bancária
        </a>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Banco</th>
                <th>Agência</th>
                <th>Conta</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
@endsection
