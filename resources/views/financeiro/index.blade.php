@extends('financeiro.components.layout')

@section('financeiro-content-header')
    Dashboard Financeiro
@endsection

@section('financeiro-content')
    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Saldo Atual</small>

                    <h3 class="text-success">
                        R$ {{ number_format($saldoAtual, 2, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Receitas do Mês</small>

                    <h3 class="text-primary">
                        R$ {{ number_format($receitasMes, 2, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-danger shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Despesas do Mês</small>

                    <h3 class="text-danger">
                        R$ {{ number_format($despesasMes, 2, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-dark shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Resultado do Mês</small>

                    <h3>
                        R$ {{ number_format($receitasMes - $despesasMes, 2, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="card shadow-sm mb-3">

                <div class="card-header">
                    Contas a Pagar
                </div>

                <div class="card-body">

                    <table class="table table-sm">

                        <thead>

                            <tr>
                                <th>Vencimento</th>
                                <th>Descrição</th>
                                <th>Valor</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($contasPagar as $conta)
                                <tr>

                                    <td>
                                        {{ $conta->data_vencimento ? $conta->data_vencimento->format('d/m/Y') : 'Não informado' }}
                                    </td>

                                    <td>
                                        {{ $conta->descricao }}
                                    </td>

                                    <td>
                                        R$ {{ number_format($conta->valor, 2, ',', '.') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3" class="text-center">
                                        Nenhuma conta.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card shadow-sm mb-3">

                <div class="card-header">
                    Contas a Receber
                </div>

                <div class="card-body">

                    <table class="table table-sm">

                        <thead>

                            <tr>
                                <th>Vencimento</th>
                                <th>Descrição</th>
                                <th>Valor</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($contasReceber as $conta)
                                <tr>

                                    <td>
                                        {{ $conta->data_vencimento ? $conta->data_vencimento->format('d/m/Y') : 'Não informado' }}
                                    </td>

                                    <td>
                                        {{ $conta->descricao }}
                                    </td>

                                    <td class="text-success">
                                        R$ {{ number_format($conta->valor, 2, ',', '.') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3" class="text-center">
                                        Nenhum recebimento.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            Últimos Lançamentos
        </div>

        <div class="card-body">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Valor</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($ultimosLancamentos as $lancamento)
                        <tr>

                            <td>
                                {{ $lancamento->data_lancamento->format('d/m/Y') }}
                            </td>

                            <td>
                                {{ $lancamento->descricao }}
                            </td>

                            <td>
                                {{ $lancamento->categoria_nome }}
                            </td>

                            <td>

                                @if ($lancamento->tipo == 'receita')
                                    <span class="badge bg-success">
                                        Receita
                                    </span>
                                @elseif($lancamento->tipo == 'despesa')
                                    <span class="badge bg-danger">
                                        Despesa
                                    </span>
                                @else
                                    <span class="badge bg-primary">
                                        Transferência
                                    </span>
                                @endif

                            </td>

                            <td>

                                R$ {{ number_format($lancamento->valor, 2, ',', '.') }}

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>
@endsection
