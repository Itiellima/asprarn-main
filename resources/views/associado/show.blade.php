@extends('layouts.main')

@section('title', 'AspraRN - Associado')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    {{-- Dados Cadastrais --}}
    @include('associado.components.dados-cadastrais')

    <div id="dashboardCollapse" class=" my-3">

        <div class="d-flex gap-2 mb-3 justify-content-center">
            <button id="btnSituacoes" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseSituacoes">
                Situação do Associado
            </button>

            <button id="btnMes" class="btn btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#collapseMes">
                Ações em andamento
            </button>
        </div>

        <div id="collapseSituacoes" class="collapse show" data-bs-parent="#dashboardCollapse">
            {{-- situacao do associado --}}
            @include('associado.components.situacao-associado')
        </div>

        <div id="collapseMes" class="collapse" data-bs-parent="#dashboardCollapse">
            {{-- acoes judiciais --}}
            @include('associado.components.acao-judicial')
        </div>

    </div>

    {{-- carteirinha digital --}}
    @include('dashboard.associadoComponents.associado-carteirinha-digital')


    {{-- Mais opções --}}
    <div class="container mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-2 text-center">
                <strong>Mais opções</strong>
            </div>

            <div class="card-body d-flex flex-wrap justify-content-center gap-2 p-3">
                <a href="{{ route('associado.pasta.index', $associado->id) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-folder"></i> Arquivos
                </a>

                <a href="{{ route('pagamentos.show', $associado->id) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-cash-stack"></i> Pagamentos
                </a>
            </div>
        </div>
    </div>


    {{-- Histórico de situações --}}
    <div class="container mb-3">
        <div class="card shadow-sm border-0">

            <div class="card-header bg-primary text-white py-2">
                <strong>Histórico de situações</strong>
            </div>

            <div class="card-body">

                @if ($associado->historicoSituacoes?->count())

                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-3">
                            <thead>
                                <tr>
                                    <th>Situação</th>
                                    <th>Início</th>
                                    <th>Fim</th>
                                    <th>Observação</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($associado->historicoSituacoes as $historico)
                                    <tr>
                                        <td>{{ $historico->situacao }}</td>
                                        <td>{{ $historico->data_inicio }}</td>
                                        <td>{{ $historico->data_fim ?? '-' }}</td>
                                        <td>{{ $historico->observacao ?? '-' }}</td>

                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editarHistorico{{ $historico->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <form
                                                action="{{ route('associado.historico.destroy', [$associado->id, $historico->id]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Tem certeza que deseja excluir este histórico?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- Modal editar --}}
                                    <div class="modal fade" id="editarHistorico{{ $historico->id }}" tabindex="-1">

                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <form
                                                    action="{{ route('associado.historico.update', [$associado->id, $historico->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            Editar histórico
                                                        </h5>

                                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">

                                                        <div class="mb-2">
                                                            <label class="form-label">Situação</label>
                                                            <input type="text" class="form-control" name="situacao"
                                                                value="{{ $historico->situacao }}" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label class="form-label">Observação</label>
                                                            <input type="text" class="form-control" name="observacao"
                                                                value="{{ $historico->observacao }}">
                                                        </div>

                                                        <div class="row g-2">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Data de início</label>
                                                                <input type="date" class="form-control"
                                                                    name="data_inicio"
                                                                    value="{{ $historico->data_inicio }}" required>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="form-label">Encerramento</label>
                                                                <input type="date" class="form-control" name="data_fim"
                                                                    value="{{ $historico->data_fim }}">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">
                                                            Cancelar
                                                        </button>

                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            Salvar
                                                        </button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center mb-3">
                        Não há histórico de situações para este associado.
                    </p>
                @endif

                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#novoHistorico">
                    <i class="bi bi-plus-lg"></i> Inserir histórico
                </button>

            </div>
        </div>
    </div>

    <div class="modal fade" id="novoHistorico" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('associado.historico.store', $associado->id) }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Novo histórico</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-2">
                            <label class="form-label">Situação</label>
                            <input type="text" class="form-control" name="situacao" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Observação</label>
                            <input type="text" class="form-control" name="observacao">
                        </div>

                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">Data de início</label>
                                <input type="date" class="form-control" name="data_inicio" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Encerramento</label>
                                <input type="date" class="form-control" name="data_fim">
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="submit" class="btn btn-primary btn-sm">
                            Inserir
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const btnSituacoes = document.getElementById('btnSituacoes');
            const btnMes = document.getElementById('btnMes');

            const collapseSituacoes = document.getElementById('collapseSituacoes');
            const collapseMes = document.getElementById('collapseMes');

            collapseSituacoes.addEventListener('show.bs.collapse', () => {
                btnSituacoes.classList.add('btn-primary');
                btnSituacoes.classList.remove('btn-outline-primary');

                btnMes.classList.add('btn-outline-primary');
                btnMes.classList.remove('btn-primary');
            });

            collapseMes.addEventListener('show.bs.collapse', () => {
                btnMes.classList.add('btn-primary');
                btnMes.classList.remove('btn-outline-primary');

                btnSituacoes.classList.add('btn-outline-primary');
                btnSituacoes.classList.remove('btn-primary');
            });
        </script>
    @endpush
@endsection
