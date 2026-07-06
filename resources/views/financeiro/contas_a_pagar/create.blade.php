@extends('financeiro.components.layout')

@section('financeiro-content-header')
    Nova Conta a Pagar
@endsection

@section('financeiro-content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Cadastrar Lançamento</h5>
        </div>

        <div class="card-body">

            <form action="{{ $conta->exists ? route('contas-a-pagar.update', $conta->id) : route('contas-a-pagar.store') }}"
                method="POST">
                @csrf
                @if ($conta->exists)
                    @method('PUT')
                @endif

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tipo</label>

                        <select name="tipo" class="form-select" required>
                            <option value="">Selecione</option>
                            <option value="{{ old('tipo', $conta->tipo ?? 'despesa') }}"
                                {{ $conta->tipo === 'despesa' ? 'selected' : '' }}>Despesa</option>
                            <option value="{{ old('tipo', $conta->tipo ?? 'receita') }}"
                                {{ $conta->tipo === 'receita' ? 'selected' : '' }}>Receita</option>
                            <option value="{{ old('tipo', $conta->tipo ?? 'transferencia') }}"
                                {{ $conta->tipo === 'transferencia' ? 'selected' : '' }}>Transferência</option>
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
                            <option value="{{ old('repeticao', $conta->repeticao ?? 'unica') }}"
                                {{ $conta->repeticao === 'unica' ? 'selected' : '' }}>Única</option>
                            <option value="{{ old('repeticao', $conta->repeticao ?? 'diaria') }}"
                                {{ $conta->repeticao === 'diaria' ? 'selected' : '' }}>Diária</option>
                            <option value="{{ old('repeticao', $conta->repeticao ?? 'semanal') }}"
                                {{ $conta->repeticao === 'semanal' ? 'selected' : '' }}>Semanal</option>
                            <option value="{{ old('repeticao', $conta->repeticao ?? 'quinzenal') }}"
                                {{ $conta->repeticao === 'quinzenal' ? 'selected' : '' }}>Quinzenal</option>
                            <option value="{{ old('repeticao', $conta->repeticao ?? 'mensal') }}"
                                {{ $conta->repeticao === 'mensal' ? 'selected' : '' }}>Mensal</option>
                            <option value="{{ old('repeticao', $conta->repeticao ?? 'anual') }}"
                                {{ $conta->repeticao === 'anual' ? 'selected' : '' }}>Anual</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Data do lançamento</label>

                        <input type="date" name="data_lancamento" class="form-control"
                            value="{{ old('data_lancamento', $conta->data_lancamento?->format('Y-m-d') ?? '') }}" required>
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

                            @foreach ($contas as $conta)
                                <option value="{{ $conta->id }}"
                                    {{ old('conta_id', $conta->conta_id ?? '') === $conta->id ? 'selected' : '' }}>
                                    {{ $conta->nome }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Categoria</label>

                        <select name="categoria_id" class="form-select">
                            <option value="">Selecione</option>

                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">
                                    {{ $categoria->nome }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Descrição</label>

                        <input type="text" class="form-control" name="descricao">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Observação</label>

                        <textarea class="form-control" rows="4" name="observacao"></textarea>
                    </div>

                </div>

                <div class="text-end">

                    <a href="{{ route('contas-a-pagar.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button class="btn btn-success">
                        Salvar
                    </button>

                </div>

            </form>

        </div>
    </div>
@endsection
