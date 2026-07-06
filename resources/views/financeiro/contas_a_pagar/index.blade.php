@extends('financeiro.components.layout')

@section('financeiro-content-header')
    Contas a pagar
@endsection

@section('financeiro-content')
    <div class="container rounded">
        <a href="{{ route('contas-a-pagar.create') }}" class="btn btn-primary">
            Nova conta a pagar
        </a>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Data do lançamento</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Conta</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contas as $conta)
                    <tr>
                        <td>{{ $conta->id }}</td>
                        <td>{{ ucfirst($conta->tipo) }}</td>
                        <td>{{ number_format($conta->valor, 2, ',', '.') }}</td>
                        <td>{{ date('d/m/Y', strtotime($conta->data_lancamento)) }}</td>
                        <td>{{ $conta->categoria->nome ?? 'Nenhuma' }}</td>
                        <td>{{ $conta->conta->nome ?? 'Nenhuma' }}</td>
                        <td>
                            <a href="{{ route('contas-a-pagar.edit', $conta->id) }}" class="btn btn-sm btn-warning">
                                Editar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
