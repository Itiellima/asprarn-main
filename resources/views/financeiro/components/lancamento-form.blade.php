{{--
    Formulário de lançamento compartilhado por Lançamentos, Contas a pagar e Contas a receber.

    Espera:
      $conta            FinanceiroLancamento (novo ou existente)
      $categorias       categorias para o select
      $contasBancarias  contas bancárias para o select
      $form = [
        'titulo'          => título do card de alteração,
        'tipos'           => ['despesa' => 'Despesa', ...] opções do campo tipo,
        'url_salvar'      => action do formulário (store ou update),
        'url_pagar'       => action de pagar/receber (só na edição),
        'url_cancelar'    => action de cancelar (só na edição),
        'url_voltar'      => link do botão Voltar,
        'texto_pagar'     => "Marcar como pago" / "Marcar como recebido",
        'texto_cancelar'  => "Cancelar pagamento" / "Cancelar recebimento",
        'data_pagamento'  => rótulo da data de pagamento/recebimento,
      ]
--}}

@php
    $bloqueado = $conta->situacao === 'cancelado' || $conta->veioDePagamento();
@endphp

@if ($conta->veioDePagamento())
    <div class="alert alert-info">
        Este lançamento foi gerado por um pagamento de associado e é atualizado automaticamente.
        Para alterá-lo, edite o pagamento na tela de pagamentos.
    </div>
@elseif ($conta->situacao === 'cancelado')
    <div class="alert alert-secondary">
        Este lançamento está cancelado e não pode mais ser alterado.
    </div>
@endif

@if ($conta->exists && !$bloqueado)
    <div class="card shadow-sm mb-3">
        <div class="card-header">
            <h5 class="mb-0">{{ $form['titulo'] }}</h5>
        </div>
        <div class="card-body">

            <form action="{{ $form['url_pagar'] }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="situacao" value="1" id="pago"
                        @checked(old('situacao', $conta->situacao === 'pago'))>
                    <label class="form-check-label" for="pago">
                        {{ $form['texto_pagar'] }}
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ $form['data_pagamento'] }}</label>
                    <div class="row d-flex align-items-end gap-2">
                        <div class="col-md-3">
                            <input type="date" name="data_pagamento" class="form-control"
                                value="{{ old('data_pagamento', $conta->data_pagamento?->format('Y-m-d') ?? date('Y-m-d')) }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mt-2">
                                Salvar
                            </button>
                        </div>
                    </div>
                </div>

            </form>

            <form action="{{ $form['url_cancelar'] }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-danger mt-2"
                    onclick="return confirm('Deseja cancelar? O lançamento sai do saldo e não poderá mais ser alterado.')">
                    {{ $form['texto_cancelar'] }}
                </button>
            </form>

        </div>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">{{ $conta->exists ? 'Dados do lançamento' : 'Cadastrar lançamento' }}</h5>
    </div>

    <div class="card-body">

        <form action="{{ $form['url_salvar'] }}" method="POST">
            @csrf
            @if ($conta->exists)
                @method('PUT')
            @endif

            <fieldset @disabled($bloqueado)>
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tipo</label>

                        <select name="tipo" class="form-select" required>
                            @if (count($form['tipos']) > 1)
                                <option value="">Selecione</option>
                            @endif
                            @foreach ($form['tipos'] as $valor => $rotulo)
                                <option value="{{ $valor }}" @selected(old('tipo', $conta->tipo) === $valor)>
                                    {{ $rotulo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Valor (R$)</label>

                        <input type="number" step="0.01" min="0.01" class="form-control" name="valor"
                            value="{{ old('valor', $conta->valor ?? '') }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Repetição</label>

                        <select name="repeticao" class="form-select">
                            @foreach (['unica' => 'Única', 'diaria' => 'Diária', 'semanal' => 'Semanal', 'quinzenal' => 'Quinzenal', 'mensal' => 'Mensal', 'anual' => 'Anual'] as $valor => $rotulo)
                                <option value="{{ $valor }}" @selected(old('repeticao', $conta->repeticao ?? 'unica') === $valor)>
                                    {{ $rotulo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Data do lançamento</label>

                        <input type="date" name="data_lancamento" class="form-control"
                            value="{{ old('data_lancamento', $conta->data_lancamento?->format('Y-m-d') ?? date('Y-m-d')) }}"
                            required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Data de vencimento</label>

                        <input type="date" name="data_vencimento" class="form-control"
                            value="{{ old('data_vencimento', $conta->data_vencimento?->format('Y-m-d') ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Conta Bancária</label>

                        <select name="conta_id" class="form-select">
                            <option value="">Selecione</option>

                            @foreach ($contasBancarias as $contaBancaria)
                                <option value="{{ $contaBancaria->id }}" @selected(old('conta_id', $conta->conta_id) == $contaBancaria->id)>
                                    {{ $contaBancaria->nome }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Categoria</label>

                        <select name="categoria_id" class="form-select">
                            <option value="">Selecione</option>

                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" @selected(old('categoria_id', $conta->categoria_id) == $categoria->id)>
                                    {{ $categoria->nome }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Descrição</label>

                        <input type="text" class="form-control" name="descricao" maxlength="255"
                            value="{{ old('descricao', $conta->descricao ?? '') }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Observação</label>

                        <textarea class="form-control" rows="4" name="observacao">{{ old('observacao', $conta->observacao ?? '') }}</textarea>
                    </div>

                </div>
            </fieldset>

            <div class="text-start">

                @unless ($bloqueado)
                    <button class="btn btn-success">
                        Salvar
                    </button>
                @endunless

                <a href="{{ $form['url_voltar'] }}" class="btn btn-secondary">
                    Voltar
                </a>

            </div>

        </form>

    </div>
</div>
