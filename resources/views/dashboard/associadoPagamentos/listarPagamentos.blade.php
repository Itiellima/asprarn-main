{{-- Meus pagamentos --}}
<div class="container mb-3">
    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white py-2">
            <strong>Meus pagamentos</strong>
        </div>

        <div class="card-body">
            @if ($pagamentos->isEmpty())
                <p class="text-muted mb-0">Nenhum pagamento registrado ainda.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Mês Referência</th>
                                <th>Valor</th>
                                <th>Data Pagamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pagamentos as $pagamento)
                                <tr>
                                    {{-- mes_referencia pode vir vazio de importações antigas --}}
                                    <td>{{ $pagamento->mes_referencia?->format('m/Y') ?? '—' }}</td>
                                    <td>R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</td>
                                    <td>{{ $pagamento->data_pagamento?->format('d/m/Y') ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $pagamentos->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
