@extends('financeiro.components.layout')

@section('financeiro-content-header')
    Contas Bancárias
@endsection

@section('financeiro-content')

    <div class="container">
        {{ $contas->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

    <div class="card shadow-sm mb-3 mt-3">

        <div class="card-header">
            <a href="{{ route('financeiro.contas_bancarias.create') }}" class="btn btn-sm btn-outline-primary float-start">
                Adicionar nova Conta
            </a>
        </div>

        <div class="card-body">

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
                    @forelse ($contas as $conta)
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
                    @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                Nenhum registro encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>
@endsection
