@extends('diretoria.components.layout')

@section('diretoria-content')
    <div class="container py-4">

        <div class="text-center mb-5">
            <h2>Funções</h2>
            <p class="text-muted">
                Conheça as funções das diretorias da ASPRA-RN
            </p>
            <a href="{{ route('diretoria.funcoes.create') }}" class="btn btn-sm btn-warning">Nova função</a>
        </div>


        <table class="table striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            @foreach ($funcoes as $funcao)
                <tbody>
                    <tr>
                        <th>{{ $funcao->nome }}</td>
                        <td>{{ $funcao->descricao }}</td>
                        <td>{{ strtoupper($funcao->status) }}</td>
                        <td>
                            <a href="{{ route('diretoria.funcoes.edit', $funcao->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('diretoria.funcoes.destroy', $funcao->id) }}" method="POST" style="display:inline;"
                                onclick="return confirm('Deseja excluir essa funcao, {{ $funcao->nome }}? Ao excluir uma função todos os membros vinculados a ela serão excluidos!');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>

                            </form>
                        </td>
                    </tr>
                </tbody>
            @endforeach
        </table>


    </div>
@endsection
