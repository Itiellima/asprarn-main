<div class="border rounded p-3">
    <h4>Meus pagamentos</h4>

    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mês Referência</th>
                    <th>Valor</th>
                    <th>Data Pagamento</th>
                    {{-- <th>Ações</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($pagamentos as $pagamento)
                    <tr>
                        <td>{{ $pagamento->mes_referencia->format('m/Y') }}</td>
                        <td>R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</td>
                        <td>{{ $pagamento->data_pagamento->format('d/m/Y') }}</td>
                        {{-- <td>
                            <a href="{{ route('pagamentos.edit', $pagamento->id) }}"
                                class="btn btn-sm btn-primary">Editar</a>

                            <form action="{{ route('pagamentos.destroy', $pagamento->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Tem certeza que deseja excluir este pagamento?')">Excluir</button>
                            </form>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $pagamentos->appends(request()->query())->links('pagination::bootstrap-5') }}

    </div>

</div>
