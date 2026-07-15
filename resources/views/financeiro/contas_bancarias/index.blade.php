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
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contas as $conta)
                <tr>
                    <td>{{ $conta->nome }}</td>
                    <td>{{ $conta->banco }}</td>
                    <td>{{ $conta->agencia }}</td>
                    <td>{{ $conta->conta }}</td>
                    <td>{{ $conta->descricao }}</td>
                    <td>
                        <a class="btn btn-sm btn-warning"
                            href="{{ route('financeiro.contas_bancarias.edit', $conta->id) }}">Editar</a>
                        <form action="{{ route('financeiro.contas_bancarias.destroy', $conta->id) }}" method="POST"
                            class="d-inline" onsubmit="confirm('Deseja excluir essa conta?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
