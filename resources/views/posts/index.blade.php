@extends('layouts.main')

@section('title', 'Comunicação')

@section('content')

    @include('dashboard.layouts.nav-dashboard')


    <div class="container body-offset">

        <div class="meu-container alert alert-light">
            <h1>
                Publicações
            </h1>
        </div>

        <div class="container mb-3">

            <a href="{{ route('posts.create') }}" class="btn btn-primary"> + Nova Publicação</a>
        </div>


        @if ($posts->count())
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col-1">Id</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Assunto</th>
                        <th scope="col">Data</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Img</th>
                        <th scope="col-2">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <th scope="row">{{ $post->id }}</th>
                            <td>{{ $post->titulo }}</td>
                            <td>{{ $post->assunto }}</td>
                            <td>{{ $post->data->format('d/m/Y') }}</td>
                            <td>{{ $post->user->name }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $post->files->first()->path) }}" alt="imagem" width="80">
                            </td>
                            <td class="row">
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                    onsubmit="return confirm('Deseja excluir essa publicação?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">🗑️ Excluir</button>
                                </form>

                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-secondary">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h3>Nenhuma publicação encontrada</h3>
        @endif
    </div>



@endsection
