@extends('layouts.main')

@section('title', 'Aspra Associado')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    {{-- Dados Cadastrais --}}
    <div class="container alert alert-light text-black">
        <h2 class="text-center mb-4">Dados cadastrais</h2>

        <div class="card shadow-sm">
            <div class="row m-3">

                {{-- COLUNA ESQUERDA --}}
                <div class="col-md-6">
                    <div class="form-control mb-3 bg-white">
                        <strong>Nome:</strong> {{ $associado->nome }}
                    </div>

                    <div class="form-control mb-3 bg-white">
                        <strong>CPF:</strong> {{ $associado->cpf }}
                    </div>

                    <div class="form-control mb-3 bg-white">
                        <strong>RG:</strong> {{ $associado->rg }}
                    </div>

                    <div class="form-control mb-3 bg-white">
                        <strong>Órgão Expedidor:</strong> {{ $associado->org_expedidor }}
                    </div>
                </div>

                {{-- COLUNA DIREITA --}}
                <div class="col-md-6">
                    <div class="form-control mb-3 bg-white">
                        <strong>Telefone:</strong> {{ $associado->contato->tel_celular ?? 'Não informado' }}
                    </div>

                    <div class="form-control mb-3 bg-white">
                        <strong>Data de Nascimento:</strong> {{ date('d/m/Y', strtotime($associado->dt_nasc)) }}
                    </div>

                    <div class="form-control mb-3 bg-white">
                        <strong>Email:</strong> {{ $associado->contato->email ?? 'Não informado' }}
                    </div>

                    {{-- BOTÕES --}}
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <a href="{{ route('associado.edit', $associado->id) }}" class="btn btn-primary w-100">Ver
                                mais</a>
                        </div>

                        <div class="col-md-6">
                            <div class="dropdown w-100">
                                <button class="btn btn-primary dropdown-toggle w-100" data-bs-toggle="dropdown">
                                    Gerar PDF
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('associado.pdf.requerimento', $associado->id) }}"
                                            target="_blank">Requerimento</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('associado.pdf.sesc', $associado->id) }}"
                                            target="_blank">Declaração SESC</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('associado.pdf.unp', $associado->id) }}"
                                            target="_blank">Declaração UNP</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('associado.pdf.declaracao', $associado->id) }}"
                                            target="_blank">Declaração Genérica</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('associado.pdf.desfiliacao', $associado->id) }}"
                                            target="_blank">Req. de Desfiliação</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- situacao do associado --}}
    @include('associado.components.situacao-associado')


    @include('dashboard.associadoComponents.associado-carteirinha-digital')

    {{-- categoria do associado --}}
    {{-- <div class="container alert alert-light text-black text-center">
        <strong class="text-black">
            <h2>Categoria do associado</h2>
        </strong>
    </div> --}}

    {{-- ACOES --}}
    <div class="container align-items-center alert alert-light text-black">
        <strong class="text-black text-center">
            <h2>Mais opções</h2>
        </strong>
        <div class="row mx-3 my-3 justify-content-center">
            {{-- <a href="{{ route('associado.documentos.index', $associado->id) }}"
                class="btn btn-primary col-2 mx-2">Documentos</a> --}}

            <a href="{{ route('associado.pasta.index', $associado->id) }}" class="btn btn-primary col-2 mx-2">Arquivos</a>

            {{-- <a href="#" class="btn btn-primary col-2 mx-2">Historico</a>
            <a href="#" class="btn btn-primary col-2 mx-2">Financeiro</a>
            <a href="#" class="btn btn-primary col-2 mx-2 disabled">#</a> --}}
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
