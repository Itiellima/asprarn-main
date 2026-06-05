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
                    <option value="{{ old('tipo', $categoria->tipo ?? '') }}" {{ $categoria->tipo === 'receita' ? 'selected' : '' }}>Receita</option>
                    <option value="{{ old('tipo', $categoria->tipo ?? '') }}" {{ $categoria->tipo === 'despesa' ? 'selected' : '' }}>Despesa</option>
                    <option value="{{ old('tipo', $categoria->tipo ?? '') }}" {{ $categoria->tipo === 'transferencia' ? 'selected' : '' }}>Transferência</option>
                </select>
            </div>
        </div>
        <div class="footer">
            <a href="{{ route('financeiro.categoria') }}" class="btn btn-secondary">Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </form>
@endsection
