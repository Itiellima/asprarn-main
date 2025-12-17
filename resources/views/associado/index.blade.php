@extends('layouts.main')

@section('title', 'Aspra Associado')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    {{-- <div class="container border rounded-3 mb-3">
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
        @endif

        @if ($associados->isEmpty())
            <p>Nenhum associado encontrado.</p>
        @else
            <p>Existem {{ $totalAssociados }} associados cadastrados.</p>
            <table class="table table-striped table-hover ">
                <tr>
                    <th scope="col-lg-1 col-md-1 col-sm-1">#</th>
                    <th scope="col-lg-3 col-md-3 col-sm-1">Nome</th>
                    <th scope="col-lg-3 col-md-3 col-sm-1">CPF</th>
                    <th scope="col-lg-2 col-md-2 col-sm-1" style="width: 200px;">Ação</th>
                </tr>
                @foreach ($associados as $associado)
                    <tr>
                        <td>{{ $associado->id }}</td>
                        <td>{{ $associado->nome }}</td>
                        <td>{{ $associado->cpf }}</td>
                        <td>
                            <a href="/associado/show/{{ $associado->id }}">Mostar informações</a>
                        </td>
                    </tr>
                @endforeach
            </table>

            {{ $associados->appends(request()->query())->links('pagination::bootstrap-5') }}
        @endif
    </div> --}}

    {{-- Lista de associados --}}

    <div class="container">
        <form method="GET" action="{{ route('associado.index') }}" class="row g-3">

            <div class="col-md-4">
                <label class="form-label">Busque um associado</label>
                <input class="form-control" type="text" name="search" value="{{ request('search') }}"
                    placeholder="Pesquisar...">
            </div>

            <div class="col-md-3">
                <label class="form-label">Cidade / UF</label>
                <select name="cidade" class="form-select">
                    <option value="">Todos</option>
                    @foreach ($cidades as $cidade)
                        <option value="{{ $cidade }}" {{ request('cidade') == $cidade ? 'selected' : '' }}>
                            {{ $cidade }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">OPM</label>
                <select name="opm" class="form-select">
                    <option value="">Todos</option>
                    @foreach ($opms as $opm)
                        <option value="{{ $opm }}" {{ request('opm') == $opm ? 'selected' : '' }}>
                            {{ $opm }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Situação</label>
                <select name="situacao" class="form-select">
                    <option value="">Todos</option>
                    @foreach ($situacoes as $situacao)
                        <option value="{{ $situacao->id }}" {{ request('situacao') == $situacao->id ? 'selected' : '' }}>
                            {{ $situacao->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100">Pesquisar</button>
            </div>

        </form>
    </div>


    <div class="container mt-3">
        {{ $associados->appends(request()->query())->links('pagination::bootstrap-5') }}
        @if (!@empty($search))
            <p>Você pesquisou por: <strong>{{ $search }}</strong></p>
        @endif
    </div>
    <div class="container border rounded-3 mb-3 d-flex flex-wrap gap-3 justify-content-center">
        @foreach ($associados as $associado)
            <div class="card mt-3 mb-3 shadow-sm" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ $associado->nome }}</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">{{ $associado->cpf }}</h6>
                    <a href="/associado/show/{{ $associado->id }}">Mostar informações</a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="container">
        {{ $associados->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>



@endsection
