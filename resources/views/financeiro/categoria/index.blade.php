@extends('financeiro.components.layout')

@section('financeiro-content-header')
    Categorias
@endsection

@section('financeiro-content')

    <div class="card shadow-sm mb-3 mt-3">
        <div class="card-header">
            <a href="{{ route('financeiro.categoria.create') }}" class="btn btn-sm btn-outline-primary float-start">
                Criar Categoria
            </a>
        </div>

        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nome }}</td>
                        <td>{{ ucfirst($categoria->tipo) }}</td>
                        <td>
                            <a href="{{ route('financeiro.categoria.editar', $categoria->id) }}"
                                class="btn btn-sm btn-warning">Editar</a>
                            <form method="POST" action="{{ route('financeiro.categoria.excluir', $categoria->id) }}"
                                style="display:inline;"
                                onclick="return confirm('Tem certeza que deseja excluir esta categoria?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    @endsection
