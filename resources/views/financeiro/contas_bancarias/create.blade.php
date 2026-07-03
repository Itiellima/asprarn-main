@extends('financeiro.components.layout')

@section('financeiro-content-header')
    Criar Conta Bancária
@endsection

@section('financeiro-content')
    <form method="POST" action="{{ $conta->exists ? route('financeiro.contas_bancarias.update', $conta->id) : route('financeiro.contas_bancarias.store') }}">
        @csrf
        @if ($conta)
            @method('PUT')
        @endif

        <div class="body">
            <div class="row">


                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input class="form-control" name="nome" type="text" placeholder="" required
                        value="{{ old('nome', $conta->nome ?? '') }}">
                </div>

                <div class="mb-3 col-md-6">
                    <label for="tipo" class="form-label">Tipo de Conta</label>
                    <select class="form-select" name="tipo" required>
                        <option value="">Selecione o tipo de conta</option>
                        <option value="{{ old('conta_bancaria', $conta->tipo ?? '') }}"
                            {{ $conta->tipo == 'conta_bancaria' ? 'selected' : '' }}>Conta Bancária</option>
                        <option value="{{ old('cartao_credito', $conta->tipo ?? '') }}"
                            {{ $conta->tipo == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="banco" class="form-label">Banco</label>
                    <select class="form-select" name="banco" id="banco" required>
                        <option value="">Selecione o Banco</option>
                        @foreach ($bancos as $banco)
                            <option value="{{ $banco['code'] }}"
                                {{ old('banco', $conta->banco ?? '') == $banco['code'] ? 'selected' : '' }}>
                                {{ $banco['code'] }} - {{ $banco['fullName'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="agencia" class="form-label">Agencia</label>
                    <input class="form-control" id="agencia" name="agencia" type="text"
                        placeholder="Digite o número da agência" required
                        value="{{ old('agencia', $conta->agencia ?? '') }}">
                </div>

                <div class="mb-3 col-md-6">
                    <label for="conta" class="form-label">Número da Conta</label>
                    <input class="form-control" id="conta" name="conta" type="text"
                        placeholder="Digite o número da conta" required value="{{ old('conta', $conta->conta ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" name="descricao">{{ old('descricao', $conta->descricao ?? '') }}</textarea>
                </div>

                <div class="footer">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>

            </div>

        </div>

    </form>

@endsection
