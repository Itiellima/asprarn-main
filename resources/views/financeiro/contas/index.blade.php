@extends('financeiro.components.layout')

@section('financeiro-content-header')
    {{ $config['titulo'] }}
@endsection

@section('financeiro-content')
    <div class="card shadow-sm mb-3 mt-3">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <a href="{{ route($config['rota'] . '.create') }}" class="btn btn-sm btn-outline-primary">
                Adicionar nova conta
            </a>

            <div class="btn-group btn-group-sm" role="group" aria-label="Filtrar por situação">
                @foreach (['pendente' => 'Pendentes', 'pago' => $config['tipo'] === 'despesa' ? 'Pagas' : 'Recebidas', 'cancelado' => 'Canceladas', 'todas' => 'Todas'] as $valor => $rotulo)
                    <a href="{{ route($config['rota'] . '.index', ['situacao' => $valor]) }}"
                        class="btn {{ $situacao === $valor ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $rotulo }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Vencimento</th>
                            <th scope="col">Descrição</th>
                            <th scope="col" class="text-end">Valor</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Conta</th>
                            <th scope="col">Situação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contas as $conta)
                            @php
                                $vencida = $conta->situacao === 'pendente' && $conta->data_vencimento?->isPast() && !$conta->data_vencimento->isToday();
                            @endphp
                            <tr style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#modalConta{{ $conta->id }}">
                                <td class="{{ $vencida ? 'text-danger fw-semibold' : '' }}">
                                    {{ $conta->data_vencimento?->format('d/m/Y') ?? '—' }}
                                </td>
                                <td>{{ $conta->descricao ?: '—' }}</td>
                                <td class="text-end">R$ {{ number_format($conta->valor, 2, ',', '.') }}</td>
                                <td>{{ $conta->categoria?->nome ?? ($conta->categoria_nome ?? 'Nenhuma') }}</td>
                                <td>{{ $conta->conta?->nome ?? 'Nenhuma' }}</td>
                                <td>
                                    @if ($conta->situacao === 'pago')
                                        <span class="badge text-bg-success">{{ $config['tipo'] === 'despesa' ? 'Paga' : 'Recebida' }}</span>
                                    @elseif ($conta->situacao === 'cancelado')
                                        <span class="badge text-bg-secondary">Cancelada</span>
                                    @elseif ($vencida)
                                        <span class="badge text-bg-danger">Vencida</span>
                                    @else
                                        <span class="badge text-bg-warning">Pendente</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="modalConta{{ $conta->id }}" tabindex="-1"
                                aria-labelledby="modalContaLabel{{ $conta->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="modalContaLabel{{ $conta->id }}">
                                                Detalhes da {{ $config['singular'] }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <strong>Valor:</strong> R$ {{ number_format($conta->valor, 2, ',', '.') }}<br>
                                            <strong>Data do lançamento:</strong> {{ $conta->data_lancamento?->format('d/m/Y') }}<br>
                                            <strong>Vencimento:</strong> {{ $conta->data_vencimento?->format('d/m/Y') ?? 'Não informado' }}<br>
                                            <strong>Categoria:</strong> {{ $conta->categoria?->nome ?? ($conta->categoria_nome ?? 'Nenhuma') }}<br>
                                            <strong>Conta:</strong> {{ $conta->conta?->nome ?? 'Nenhuma' }}<br>
                                            <strong>Situação:</strong> {{ ucfirst($conta->situacao) }}<br>
                                            <strong>{{ $config['data_pagamento'] }}:</strong>
                                            {{ $conta->data_pagamento?->format('d/m/Y') ?? 'Não informado' }}<br>
                                            <strong>Descrição:</strong> {{ $conta->descricao ?? 'Nenhuma' }}<br>
                                            <strong>Observação:</strong> {{ $conta->observacao ?? 'Nenhuma' }}
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ route($config['rota'] . '.edit', $conta->id) }}" class="btn btn-warning">
                                                Detalhes / Editar
                                            </a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Nenhuma conta encontrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $contas->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
