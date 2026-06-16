@extends('diretoria.components.layout')

@section('diretoria-content')
    <div class="container py-4">

        <div class="text-center mb-5">
            <h2>Diretorias</h2>
            <p class="text-muted">
                Conheça as diretorias da ASPRA-RN
            </p>
            <a href="{{ route('diretoria.create') }}" class="btn btn-sm btn-warning">Nova diretoria</a>
        </div>


        <table class="table striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sigla</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            @foreach ($diretorias as $dir)
                <tbody>
                    <tr>
                        <th>{{ $dir->nome }}</td>
                        <td>{{ $dir->sigla }}</td>
                        <td>{{ strtoupper($dir->status) }}</td>
                        <td>
                            <a href="{{ route('diretoria.edit', $dir->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('diretoria.destroy', $dir->id) }}" method="POST" style="display:inline;"
                                onclick="return confirm('Deseja excluir essa diretoria, {{ $dir->nome }}? Ao excluir uma diretoria todos os membros vinculados a ela serão excluidos!');">
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
