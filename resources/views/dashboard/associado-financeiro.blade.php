@extends('layouts.main')

@section('title', 'ASPRARN - Pagamento')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container">
        <div class="alert alert-light">
            <h4 class="text-black">Realizar Pagamento</h4>

            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="valor" class="form-label">Valor a Pagar:</label>
                    <input type="text" class="form-control" id="valor" name="valor" value="R$ 72,30" readonly>
                </div>
                <div class="mb-3">
                    <label for="referencia" class="form-label">Mês de Referência:</label>
                    <input type="text" class="form-control" id="referencia" name="referencia" value="Janeiro/2024" readonly>
                </div>
                <div class="mb-3">
                    <label for="metodo_pagamento" class="form-label">Método de Pagamento:</label>
                    <select class="form-select" id="metodo_pagamento" name="metodo_pagamento" required>
                        <option value="">Selecione...</option>
                        <option value="pix">PIX</option>
                        {{-- <option value="boleto">Boleto Bancário</option>
                        <option value="cartao_credito">Cartão de Crédito</option> --}}
                    </select>
                </div>
                <button type="submit" class="btn btn-success" disabled>Processar Pagamento</button>
            </form>
        </div>
    </div>
@endsection
