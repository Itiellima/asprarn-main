@extends('layouts.main')

@section('title', 'Associados')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container py-4">

        {{-- Cabeçalho --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <div>
                <h3 class="mb-1">
                    <i class="fa-solid fa-users me-2"></i>
                    Associados
                </h3>
                <p class="text-muted mb-0">
                    Consulte e filtre os associados cadastrados.
                </p>
            </div>
        </div>

        {{-- Filtros --}}
        <div class="card shadow border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="fa-solid fa-filter me-2"></i>
                    Filtros
                </h5>
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('associado.index') }}">

                    <div class="row g-3">

                        {{-- Pesquisa --}}
                        <div class="col-12 col-md-6 col-lg-4">
                            <label for="search" class="form-label">
                                Associado
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>

                                <input type="text" id="search" name="search" class="form-control"
                                    value="{{ request('search') }}" placeholder="Nome ou CPF...">
                            </div>
                        </div>

                        {{-- Cidade --}}
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="cidade" class="form-label">
                                Cidade / UF
                            </label>

                            <select name="cidade" id="cidade" class="form-select">
                                <option value="">Todas</option>

                                @foreach ($cidades as $cidade)
                                    <option value="{{ $cidade }}" @selected(request('cidade') == $cidade)>
                                        {{ $cidade }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- OPM --}}
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="opm" class="form-label">
                                OPM
                            </label>

                            <select name="opm" id="opm" class="form-select">
                                <option value="">Todas</option>

                                @foreach ($opms as $opm)
                                    <option value="{{ $opm }}" @selected(request('opm') == $opm)>
                                        {{ $opm }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Situação --}}
                        <div class="col-12 col-md-6 col-lg-2">
                            <label for="situacao" class="form-label">
                                Situação
                            </label>

                            <select name="situacao" id="situacao" class="form-select">
                                <option value="">Todas</option>

                                @foreach ($situacoes as $situacao)
                                    <option value="{{ $situacao->id }}" @selected(request('situacao') == $situacao->id)>
                                        {{ $situacao->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Botões --}}
                        <div class="col-12 d-flex flex-column flex-sm-row justify-content-end gap-2 mt-3">

                            <a href="{{ route('associado.index') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-rotate-left me-1"></i>
                                Limpar filtros
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass me-1"></i>
                                Pesquisar
                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>


        {{-- Informações da pesquisa --}}
        @if (request()->hasAny(['search', 'cidade', 'opm', 'situacao']))
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">

                <span class="text-muted">
                    Filtros aplicados:
                </span>

                @if (filled(request('search')))
                    <span class="badge text-bg-primary">
                        Busca: {{ request('search') }}
                    </span>
                @endif

                @if (filled(request('cidade')))
                    <span class="badge text-bg-secondary">
                        Cidade: {{ request('cidade') }}
                    </span>
                @endif

                @if (filled(request('opm')))
                    <span class="badge text-bg-secondary">
                        OPM: {{ request('opm') }}
                    </span>
                @endif

                @if (filled(request('situacao')))
                    @php
                        $situacaoSelecionada = $situacoes->firstWhere('id', request('situacao'));
                    @endphp

                    @if ($situacaoSelecionada)
                        <span class="badge text-bg-secondary">
                            Situação: {{ $situacaoSelecionada->nome }}
                        </span>
                    @endif
                @endif

            </div>
        @endif


        {{-- Resultado --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h5 class="mb-0">
                    Resultados
                </h5>

                <small class="text-muted">
                    {{ $associados->total() }}
                    {{ $associados->total() == 1 ? 'associado encontrado' : 'associados encontrados' }}
                </small>
            </div>

        </div>


        {{-- Lista --}}
        @if ($associados->count())

            <div class="row g-4">

                @foreach ($associados as $associado)
                    @php
                        $ativo = $associado->situacoes->contains(function ($situacao) {
                            return strtolower($situacao->nome) === 'ativo';
                        });
                    @endphp

                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                        <div class="card h-100 shadow border-0">

                            {{-- Cabeçalho do card --}}
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-start mb-3">

                                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                        <i class="fa-solid fa-user text-primary fs-5"></i>
                                    </div>

                                    @if ($ativo)
                                        <span class="badge text-bg-success">
                                            <i class="fa-solid fa-circle-check me-1"></i>
                                            Ativo
                                        </span>
                                    @else
                                        <span class="badge text-bg-secondary">
                                            Inativo
                                        </span>
                                    @endif

                                </div>

                                <h5 class="card-title nome-associado mb-1">
                                    {{ $associado->nome }}
                                </h5>

                                <p class="text-muted small mb-3">
                                    CPF: {{ $associado->cpf }}
                                </p>

                                <a href="{{ route('associado.show', $associado->id) }}"
                                    class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fa-solid fa-eye me-1"></i>
                                    Ver informações
                                </a>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>
        @else
            {{-- Nenhum resultado --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">

                    <div class="mb-3">
                        <i class="fa-solid fa-users-slash fa-3x text-muted"></i>
                    </div>

                    <h5>Nenhum associado encontrado</h5>

                    <p class="text-muted mb-3">
                        Não encontramos associados para os filtros informados.
                    </p>

                    <a href="{{ route('associado.index') }}" class="btn btn-outline-primary">
                        <i class="fa-solid fa-rotate-left me-1"></i>
                        Limpar filtros
                    </a>

                </div>
            </div>

        @endif


        {{-- Paginação --}}
        @if ($associados->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $associados->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>

@endsection
