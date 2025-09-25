@extends('layouts.main')

@section('title', 'Aspra Associado')

@section('content')

    <div class="container border">
        <h2>Informações do associado</h2>
        @if ($associado->id != null)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Ação</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $associado->nome }}</td>
                        <td>{{ date('d/m/Y', strtotime($associado->dt_nasc)) }}</td>
                        <td>{{ $associado->contato->tel_celular }}</td>
                        <td>{{ $associado->contato->email }}</td>
                        <td>
                            <div class="dropdown-center">
                                <li class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Associado
                                </li>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#">#</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/associado/edit/{{ $associado->id }}">Ver tudo</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('associado.pdf.requerimento', $associado->id) }}"
                                            target="_blank">
                                            Gerar requerimento
                                        </a>
                                    </li>
                                </ul>
                            </div>


                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <p>Associado não encontrado.</p>
        @endif
    </div>

    {{-- situacao --}}
    <div class="container align-items-center border">
        <form action="{{ route('associado.situacao.store', $associado->id) }}" method="POST">
            @csrf

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1"
                    {{ old('ativo', $associado->situacao->ativo ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="ativo">Ativo</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inadimplente" name="inadimplente" value="1"
                    {{ old('ativo', $associado->situacao->inadimplente ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="inadimplente">Inadimplente</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="pendente_documento" name="pendente_documento"
                    value="1" {{ old('ativo', $associado->situacao->pendente_documento ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="pendente_documento">Pendente documento</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="pendente_financeiro" name="pendente_financeiro"
                    value="1" {{ old('ativo', $associado->situacao->pendente_financeiro ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="pendente_financeiro">Pendente financeiro</label>
            </div>

            <button type="submit" class="btn btn-primary mt-3 mb-3">Salvar</button>

        </form>
    </div>

    {{-- ACOES --}}
    <div class="container align-items-center border border my-3">
        <div class="row mx-3 my-3">
            {{-- <a href="{{ route('associado.documentos.index', $associado->id) }}"
                class="btn btn-primary col-2 mx-2">Documentos</a> --}}
                
            <a href="{{ route('associado.pasta_documento.index', $associado->id) }}"
                class="btn btn-primary col-2 mx-2">Arquivos</a>

            <a href="#" class="btn btn-primary col-2 mx-2">Historico</a>
            <a href="#" class="btn btn-primary col-2 mx-2">Financeiro</a>
            <a href="#" class="btn btn-primary col-2 mx-2 disabled">#</a>
        </div>
    </div>

    {{-- Painel Historico de situação --}}
    <div class="container border mt-3 mb-4">

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
                                        <button class="btn btn-danger btn-sm" type="submit"
                                            onclick="return confirm('Tem certeza que deseja excluir este historico?')">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
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
            <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel3" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel3">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h3>Historico de {{ $associado->nome }}</h3>
                            {{-- Formulário de envio documento --}}
                            <form action="{{ route('associado.historico.store', $associado->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <label>Tipo de Documento</label>
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
