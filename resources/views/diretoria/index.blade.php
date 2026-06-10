@extends('diretoria.components.layout')

@section('diretoria-content')



    <div class="container">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{ route('diretoria.create') }}" class="btn btn-warning">Nova diretoria</a>
        </div>

        <table class="table striped">
            <thead>
                <th>
                    <td>Nome</td>
                    <td>Sigla</td>
                    <td>Status</td>
                    <td>Ações</td>
                </th>
            </thead>
            @foreach ($diretorias as $dir)
            <tbody>
                <th>
                    <td>{{ $dir->nome }}</td>
                    <td>{{ $dir->sigla }}</td>
                    <td>{{ strtoupper($dir->status) }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Editar</button>
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </td>
                </th>    
            </tbody>
            @endforeach
        </table>

    </div>
@endsection
