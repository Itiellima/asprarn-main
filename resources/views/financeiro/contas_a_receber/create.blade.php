@extends('financeiro.components.layout')

@section('financeiro-content-header')
    Nova Conta a Receber
@endsection

@push('scripts')
    @if ($conta->situacao === 'cancelado')
        <script>
            document.querySelectorAll('#formulario input, #formulario select, #formulario textarea, #formulario button')
                .forEach(el => el.disabled = true);
        </script>
    @endif
@endpush

@section('financeiro-content')
    @if ($conta->exists)
        <div class="card shadow-sm mb-3" id="formulario">
            <div class="card-header">
                <h5 class="mb-0">Alterar Conta a Receber</h5>
            </div>
            <div class="card-body">

                <form action="{{ route('financeiro.contas-a-receber.receber', $conta->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="situacao" id="pago"
                            {{ old('situacao', $conta->situacao === 'pago') ? 'checked' : '' }}>
                        <label class="form-check-label" for="pago">
                            Marcar como Recebido
                        </label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Data de Pagamento</label>
                        <div class="row d-flex align-items-end gap-2">
                            <div class="col-md-3">
                                <input type="date" name="data_pagamento" class="form-control"
                                    value="{{ old('data_pagamento', $conta->data_pagamento?->format('Y-m-d') ?? '') }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mt-2">
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </div>

                </form>

                <div class="mb-3">
                    <div class="row d-flex align-items-end gap-2">
                        <div class="col-auto">
                            <form action="{{ route('financeiro.contas-a-receber.cancelar-recebimento', $conta->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger mt-2"
                                    onclick="return confirm('Deseja cancelar esse recebimento?')">
                                    Cancelar recebimento
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="card shadow-sm" id="formulario">
        <div class="card-header">
            <h5 class="mb-0">Cadastrar Lançamento</h5>
        </div>

        <div class="card-body">

            <form
                action="{{ $conta->exists ? route('contas-a-receber.update', $conta->id) : route('contas-a-receber.store') }}"
                method="POST">
                @csrf
                @if ($conta->exists)
                    @method('PUT')
                @endif

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tipo</label>

                        <select name="tipo" class="form-select" required>
                            {{-- <option value="">Selecione</option> --}}
                            {{-- <option value="despesa" @selected(old('tipo', $conta->tipo) === 'despesa')>
                                Despesa
                            </option> --}}
                            <option value="receita" @selected(old('tipo', $conta->tipo) === 'receita')>
                                Receita
                            </option>
                            {{-- <option value="transferencia" @selected(old('tipo', $conta->tipo) === 'transferencia')>
                                Transferência
                            </option> --}}
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Valor</label>

                        <input type="number" step="0.01" min="0" class="form-control" name="valor"
                            value="{{ old('valor', $conta->valor ?? '') }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Repetição</label>

                        <select name="repeticao" class="form-select">
                            <option value="">Selecione</option>
                            <option value="unica" @selected(old('repeticao', $conta->repeticao) === 'unica')>
                                Única
                            </option>
                            <option value="diaria" @selected(old('repeticao', $conta->repeticao) === 'diaria')>
                                Diária
                            </option>
                            <option value="semanal" @selected(old('repeticao', $conta->repeticao) === 'semanal')>
                                Semanal
                            </option>
                            <option value="quinzenal" @selected(old('repeticao', $conta->repeticao) === 'quinzenal')>
                                Quinzenal
                            </option>
                            <option value="mensal" @selected(old('repeticao', $conta->repeticao) === 'mensal')>
                                Mensal
                            </option>
                            <option value="anual" @selected(old('repeticao', $conta->repeticao) === 'anual')>
                                Anual
                            </option>
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

                        <input type="text" class="form-control" name="descricao"
                            value="{{ old('descricao', $conta->descricao ?? '') }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Observação</label>

                        <textarea class="form-control" rows="4" name="observacao">{{ old('observacao', $conta->observacao ?? '') }}</textarea>
                    </div>

                </div>

                <div class="text-start">

                    <button class="btn btn-success">
                        Salvar
                    </button>

                    <a href="{{ route('contas-a-receber.index') }}" class="btn btn-secondary">
                        Voltar
                    </a>

                </div>

            </form>

        </div>
    </div>
@endsection
