{{-- Minha situação (somente leitura). A observação do histórico é anotação da diretoria e não aparece aqui. --}}
@php
    $data = fn ($valor) => $valor ? \Carbon\Carbon::parse($valor)->format('d/m/Y') : null;
@endphp

<div class="container mb-3">
    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white py-2">
            <strong>Minha situação</strong>
        </div>

        <div class="card-body">
            <small class="text-muted">Situação atual</small>
            <div class="mb-3">
                @forelse ($situacoes as $situacao)
                    <span class="badge bg-primary me-1">{{ $situacao->nome }}</span>
                @empty
                    <span class="text-muted">Nenhuma situação registrada.</span>
                @endforelse
            </div>

            @if ($historicoSituacoes->isNotEmpty())
                <small class="text-muted">Histórico</small>
                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Situação</th>
                                <th>Início</th>
                                <th>Fim</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($historicoSituacoes as $historico)
                                <tr>
                                    <td>{{ $historico->situacao ?? '—' }}</td>
                                    <td>{{ $data($historico->data_inicio) ?? '—' }}</td>
                                    <td>{{ $data($historico->data_fim) ?? 'Atual' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
