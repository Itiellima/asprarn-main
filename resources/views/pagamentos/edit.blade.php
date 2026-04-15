@extends('layouts.main')

@section('title', 'AspraRN - Bem vindo')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    'associado_id',
    'valor',
    'data_pagamento',
    'mes_referencia',
    'metodo_pagamento',
    'tipo',
    'status',
    'numero_documento',
    'origem',
    'user_id',
    'observacao',

    <div class="container">
        <h3>Editar Pagamento</h3>

        <form action="" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="text" class="form-control" id="valor" name="valor" value="{{ $pagamento->valor }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="data_pagamento" class="form-label">Data de Pagamento</label>
                <input type="date" class="form-control" id="data_pagamento" name="data_pagamento"
                    value="{{ $pagamento->data_pagamento->format('Y-m-d') }}" required>
            </div>

            <div class="mb-3">
                <label for="mes_referencia" class="form-label">Mês de Referência</label>
                <input type="month" class="form-control" id="mes_referencia" name="mes_referencia"
                    value="{{ $pagamento->mes_referencia->format('Y-m') }}" required>
            </div>

            <div class="mb-3">
                <label for="metodo_pagamento" class="form-label">Método de Pagamento</label>
                <select class="form-select" id="metodo_pagamento" name="metodo_pagamento" required>
                    <option value="" {{ $pagamento->metodo_pagamento === '' ? 'selected' : '' }}>Selecione um método de pagamento</option>
                    <option value="boleto" {{ $pagamento->metodo_pagamento === 'boleto' ? 'selected' : '' }}>Boleto</option>
                    <option value="cartao" {{ $pagamento->metodo_pagamento === 'cartao' ? 'selected' : '' }}>Cartão de Crédito</option>
                    <option value="pix" {{ $pagamento->metodo_pagamento === 'pix' ? 'selected' : '' }}>Pix</option>
                    <option value="dinheiro" {{ $pagamento->metodo_pagamento === 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="observacao" class="form-label">Observação</label>
                <textarea class="form-control" id="observacao" name="observacao">{{ $pagamento->observacao }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>





@endsection
