@extends('financeiro.components.layout')

@section('financeiro-content-header')
    Extrato Bancário
@endsection

@section('financeiro-content')
    <div class="card shadow-sm">

        <div class="card-header">
            <form method="GET" class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Conta Bancária</label>

                    <select name="conta_id" class="form-select">
                        <option value="">Selecione</option>

                        @foreach ($contas as $conta)
                            <option value="{{ $conta->id }}" @selected(request('conta_id') == $conta->id)>
                                {{ $conta->nome }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Período Inicial</label>

                    <input type="date" name="inicio" class="form-control" value="{{ request('inicio') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Período Final</label>

                    <input type="date" name="fim" class="form-control" value="{{ request('fim') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        Filtrar
                    </button>
                </div>

            </form>
        </div>

        <div class="card-body">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th class="text-end">Valor</th>
                        <th class="text-end">Saldo</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($movimentacoes as $movimento)
                        <tr>

                            <td>
                                {{ $movimento->data_lancamento->format('d/m/Y') ? $movimento->data_lancamento->format('d/m/Y') : '' }}
                            </td>

                            <td>
                                {{ $movimento->descricao }}
                            </td>

                            <td>
                                {{ $movimento->categoria?->nome ? $movimento->categoria?->nome : 'Nenhuma' }}
                            </td>

                            <td>

                                @if ($movimento->tipo == 'receita')
                                    <span class="badge bg-success">
                                        Receita
                                    </span>
                                @elseif($movimento->tipo == 'despesa')
                                    <span class="badge bg-danger">
                                        Despesa
                                    </span>
                                @else
                                    <span class="badge bg-primary">
                                        Transferência
                                    </span>
                                @endif

                            </td>

                            <td class="text-end">

                                @if ($movimento->tipo == 'receita')
                                    <span class="text-success">
                                        + R$ {{ number_format($movimento->valor, 2, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-danger">
                                        - R$ {{ number_format($movimento->valor, 2, ',', '.') }}
                                    </span>
                                @endif

                            </td>

                            <td class="text-end">
                                R$ {{ number_format($movimento->saldo, 2, ',', '.') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                Nenhuma movimentação encontrada.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
@endsection
