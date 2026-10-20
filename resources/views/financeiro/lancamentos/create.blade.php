@extends('financeiro.components.layout')

@section('financeiro-content-header')
    {{ $conta->exists ? 'Alterar lançamento' : 'Novo lançamento' }}
@endsection

@section('financeiro-content')
    @include('financeiro.components.lancamento-form', [
        'form' => [
            'titulo' => 'Alterar situação do lançamento',
            'tipos' => ['receita' => 'Receita', 'despesa' => 'Despesa', 'transferencia' => 'Transferência'],
            'url_salvar' => $conta->exists ? route('lancamentos.update', $conta->id) : route('lancamentos.store'),
            'url_pagar' => $conta->exists ? route('financeiro.lancamentos.pagar', $conta->id) : null,
            'url_cancelar' => $conta->exists ? route('financeiro.lancamentos.cancelar-recebimento', $conta->id) : null,
            'url_voltar' => route('lancamentos.index'),
            'texto_pagar' => 'Marcar como pago / recebido',
            'texto_cancelar' => 'Cancelar lançamento',
            'data_pagamento' => 'Data de pagamento',
        ],
    ])
@endsection
