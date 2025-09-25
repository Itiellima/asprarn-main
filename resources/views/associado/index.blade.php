@extends('layouts.main')

@section('title', 'Aspra Associado')

@section('content')

@include('layouts.nav-dashboard')

    <div class="container border rounded-3 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
            <h1>Lista de associados</h1>
        </div>

        <div id="search-container" class="col-md-12 mb-3">
            <label for="form-label">Busque um associado</label>
            <form method="GET" action="{{ route('associado.index') }}">
                <input class="form-control" type="text" name="search" value="{{ $search ?? '' }}"
                    placeholder="Pesquisar...">
            </form>

        </div>

        @if (!@empty($search))
            <p>Você pesquisou por: <strong>{{ $search }}</strong></p>
        @else
        @endif

        @if ($associados->isEmpty())
            <p>Nenhum associado encontrado.</p>
        @else
            <p>Existem {{ $associados->count() }} associados cadastrados.</p>
            <table class="table table-striped table-hover ">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col" style="width: 200px;">Ação</th>
                </tr>
                @foreach ($associados as $associado)
                    <tr>
                        <td>{{ $associado->id }}</td>
                        <td>{{ $associado->nome }}</td>
                        <td>{{ $associado->cpf }}</td>
                        <td>
                            <a href="/associado/show/{{ $associado->id }}">Mostar informações</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>

            {{ $associados->appends(request()->query())->links('pagination::bootstrap-5') }}
        @endif

        
    </div>





@endsection
