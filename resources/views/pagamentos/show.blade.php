@extends('layouts.main')

@section('title', 'AspraRN - Bem vindo')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container">
        <h3>Pagamentos de {{ $associado->nome }}</h3>
    </div>

    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Valor</th>
                    <th>Mês Referência</th>
                    <th>Data Pagamento</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pagamentos as $pagamento)
                    <tr>
                        <td>R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</td>
                        <td>{{ $pagamento->mes_referencia->format('m/Y') }}</td>
                        <td>{{ $pagamento->data_pagamento->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        {{ $pagamentos->links() }}
    </div>
    




@endsection
