@extends('financeiro.components.layout')

@section('financeiro-content-header')
    Criar Conta Bancária
@endsection

@section('financeiro-content')
    <form method="POST" action="">
        @csrf
        <div class="body">

            <div class="row">

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input class="form-control" name="nome" type="text" placeholder="" required>
                </div>

                <div class="mb-3">
                    <label for="categoria" class="form-label">Tipo de Conta</label>
                    <select class="form-select" name="tipo" required>
                        <option value="">Selecione o tipo de conta</option>
                        <option value="conta_bancaria">Conta Bancária</option>
                        <option value="cartao_credito">Cartão de Crédito</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="banco" class="form-label">Banco</label>
                    <select class="form-select" name="banco" id="banco" required>
                        <option value="">Selecione o Banco</option>
                        @foreach ($bancos as $banco)
                            <option value="{{ $banco['code'] }}">{{ $banco['code'] }} - {{ $banco['fullName'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="agencia" class="form-label">Agencia</label>
                    <input class="form-control" name="agencia" type="number" placeholder="Digite o número da agência" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="conta" class="form-label">Número da Conta</label>
                    <input class="form-control" name="conta" type="number" placeholder="Digite o número da conta" required>
                </div>
            </div>

        </div>



        <div class="footer">
            <a href="" class="btn btn-secondary">Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </form>
@endsection
