@extends('layouts.main')

@section('title', 'AspraRN - Associado')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    {{-- Dados Cadastrais --}}
    @include('associado.components.dados-cadastrais')

    {{-- situacao do associado --}}
    @include('associado.components.situacao-associado')

    {{-- acoes judiciais --}}
    @include('associado.components.acao-judicial')

    {{-- carteirinha digital --}}
    @include('dashboard.associadoComponents.associado-carteirinha-digital')


    {{-- ACOES --}}
    <div class="container align-items-center alert alert-light text-black">
        <strong class="text-black text-center">
            <h2>Mais opções</h2>
        </strong>
        <div class="justify-content-center align-items-center d-flex flex-wrap gap-2 mt-3">

            <a href="{{ route('associado.pasta.index', $associado->id) }}" class="btn btn-primary mx-2">Arquivos</a>
            <a href="{{ route('pagamentos.show', $associado->id) }}" class="btn btn-primary mx-2">Pagamentos</a>

        </div>
    </div>

    {{-- Painel Historico de situação --}}
    <div class="container alert alert-light text-black">

        <div class="container my-3">
            <h3>Histórico de Situações do associado</h3>
            @if ($associado->historicoSituacoes && $associado->historicoSituacoes->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Situação</th>
                            <th>Data de inicio</th>
                            <th>Data de finalização</th>
                            <th>Observacao</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($associado->historicoSituacoes as $historico)
                            <tr>
                                <td>{{ $historico->situacao }}</td>
                                <td>{{ $historico->data_inicio }}</td>
                                <td>{{ $historico->data_fim }}</td>
                                <td>{{ $historico->observacao }}</td>
                                <td>
                                    <form
                                        action="{{ route('associado.historico.destroy', [$associado->id, $historico->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm m-1" style="width: 3cm" type="submit"
                                            onclick="return confirm('Tem certeza que deseja excluir este historico?')">
                                            Excluir
                                        </button>
                                    </form>
                                    <button class="btn btn-warning btn-sm m-1" style="width: 3cm" type="button"
                                        data-bs-toggle="modal" data-bs-target="#staticBackdrop1{{ $historico->id }}">
                                        Editar
                                    </button>

                                </td>
                            </tr>

                            {{-- Modal Editar --}}
                            <div class="modal fade" id="staticBackdrop1{{ $historico->id }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="staticBackdropLabel1{{ $historico->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel1{{ $historico->id }}">
                                                Editar Historico</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h3>Historico de {{ $associado->nome }}</h3>

                                            <form
                                                action="{{ route('associado.historico.update', [$associado->id, $historico->id]) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <label>Situação</label>
                                                <input type="text" class="form-control" name="situacao" required
                                                    value="{{ $historico->situacao }}">
                                                <label>Observação</label>
                                                <input type="text" class="form-control" name="observacao"
                                                    value="{{ $historico->observacao }}">
                                                <label>Data de Inicio</label>
                                                <input type="date" class="form-control" name="data_inicio" required
                                                    value="{{ $historico->data_inicio }}">
                                                <label>Encerramento</label>
                                                <input type="date" class="form-control" name="data_fim"
                                                    value="{{ $historico->data_fim }}">

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Voltar</button>
                                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Não há histórico de situações para este associado.</p>
            @endif

            {{-- Botão para abrir modal de inserir historico --}}
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop3">
                Inserir Historico
            </button>

            {{-- Modal Historico --}}
            <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel3">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h3>Historico de {{ $associado->nome }}</h3>
                            {{-- Formulário de envio documento --}}
                            <form action="{{ route('associado.historico.store', $associado->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <label>Situação</label>
                                <input type="text" class="form-control" name="situacao" required>
                                <label>Observação</label>
                                <input type="text" class="form-control" name="observacao">
                                <label>Data de Inicio</label>
                                <input type="date" class="form-control" name="data_inicio" required>
                                <label>Encerramento</label>
                                <input type="date" class="form-control" name="data_fim">

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Voltar</button>
                                    <button type="submit" class="btn btn-primary">Inserir</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>


@endsection
