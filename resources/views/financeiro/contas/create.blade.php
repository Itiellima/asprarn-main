@extends('financeiro.components.layout')

@section('financeiro-content-header')
    {{ $conta->exists ? 'Alterar ' . $config['singular'] : 'Nova ' . $config['singular'] }}
@endsection

@section('financeiro-content')
    @include('financeiro.components.lancamento-form', [
        'form' => [
            'titulo' => 'Alterar ' . $config['singular'],
            'tipos' => $config['tipos'],
            'url_salvar' => $conta->exists
                ? route($config['rota'] . '.update', $conta->id)
                : route($config['rota'] . '.store'),
            'url_pagar' => $conta->exists ? route($config['rota_pagar'], $conta->id) : null,
            'url_cancelar' => $conta->exists ? route($config['rota_cancelar'], $conta->id) : null,
            'url_voltar' => route($config['rota'] . '.index'),
            'texto_pagar' => $config['texto_pagar'],
            'texto_cancelar' => $config['texto_cancelar'],
            'data_pagamento' => $config['data_pagamento'],
        ],
    ])
@endsection
