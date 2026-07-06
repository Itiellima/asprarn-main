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

        <form action="{{ route('contas-a-pagar.store') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipo</label>

                    <select name="tipo" class="form-select" required>
                        <option value="">Selecione</option>
                        <option value="despesa">Despesa</option>
                        <option value="receita">Receita</option>
                        <option value="transferencia">Transferência</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Valor</label>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        class="form-control"
                        name="valor"
                        required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Repetição</label>

                    <select name="repeticao" class="form-select">
                        <option value="unica">Única</option>
                        <option value="diaria">Diária</option>
                        <option value="semanal">Semanal</option>
                        <option value="quinzenal">Quinzenal</option>
                        <option value="mensal">Mensal</option>
                        <option value="anual">Anual</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Data do lançamento</label>

                    <input
                        type="date"
                        name="data_lancamento"
                        class="form-control"
                        value="{{ date('Y-m-d') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Data de vencimento</label>

                    <input
                        type="date"
                        name="data_vencimento"
                        class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Conta Bancária</label>

                    <select name="conta_id" class="form-select">
                        <option value="">Selecione</option>

                        @foreach ($contas as $conta)
                            <option value="{{ $conta->id }}">
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

                    <input
                        type="text"
                        class="form-control"
                        name="descricao">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Observação</label>

                    <textarea
                        class="form-control"
                        rows="4"
                        name="observacao"></textarea>
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