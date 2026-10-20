@extends('financeiro.components.layout')

@section('financeiro-content')
    <form method="POST" action="{{ $categoria->exists ? route('financeiro.categoria.update', $categoria->id) : route('financeiro.categoria.criar') }}">
        <div class="body">
            @csrf
            @if ($categoria->exists)
                @method('PUT')
            @else
                @method('POST')
            @endif

            <div class="mb-3">
                <label for="categoria" class="form-label">Nome da Categoria</label>
                <input type="text" class="form-control" name="nome" id="categoria" placeholder="Ex: Salário"
                    oninput="this.value = this.value.toUpperCase()"
                    value="{{ old('nome', $categoria->nome ?? '') }}">
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select class="form-select" name="tipo" id="tipo">
                    <option value="">Selecione o tipo</option>
                    <option value="receita" @selected(old('tipo', $categoria->tipo ?? '') === 'receita')>Receita</option>
                    <option value="despesa" @selected(old('tipo', $categoria->tipo ?? '') === 'despesa')>Despesa</option>
                    <option value="transferencia" @selected(old('tipo', $categoria->tipo ?? '') === 'transferencia')>Transferência</option>
                </select>
            </div>
        </div>
        <div class="footer">
            <a href="{{ route('financeiro.categoria.index') }}" class="btn btn-warning">Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </form>
@endsection
