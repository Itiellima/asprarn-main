{{-- Minhas ações judiciais (somente leitura) --}}
@php
    $data = fn ($valor) => $valor ? \Carbon\Carbon::parse($valor)->format('d/m/Y') : null;
@endphp

<div class="container mb-3">
    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white py-2">
            <strong>Minhas ações judiciais</strong>
        </div>

        <div class="card-body">
            @forelse ($acoesJudiciais as $acao)
                <div class="@if (!$loop->last) border-bottom pb-3 mb-3 @endif">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                        <div class="fw-semibold">{{ $acao->nome }}</div>
                        @if ($acao->status)
                            <span class="badge bg-secondary">{{ $acao->status }}</span>
                        @endif
                    </div>

                    @if ($acao->descricao)
                        <div class="mt-1">{{ $acao->descricao }}</div>
                    @endif

                    @if ($data($acao->data_inicio) || $data($acao->data_fim))
                        <small class="text-muted d-block mt-1">
                            @if ($data($acao->data_inicio))
                                Início: {{ $data($acao->data_inicio) }}
                            @endif
                            @if ($data($acao->data_fim))
                                · Fim: {{ $data($acao->data_fim) }}
                            @endif
                        </small>
                    @endif
                </div>
            @empty
                <p class="text-muted mb-0">Você não está incluído em nenhuma ação judicial.</p>
            @endforelse
        </div>
    </div>
</div>
