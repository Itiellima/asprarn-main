@extends('layouts.main')

@section('title', 'AspraRN - Bem vindo')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container">
        <h3>Pagamentos de <strong>{{ $associado->nome }}</strong></h3>
    </div>

    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mês Referência</th>
                    <th>Valor</th>
                    <th>Data Pagamento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pagamentos as $pagamento)
                    <tr>
                        <td>{{ $pagamento->mes_referencia->format('m/Y') }}</td>
                        <td>R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</td>
                        <td>{{ $pagamento->data_pagamento->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('pagamentos.edit', $pagamento->id) }}" class="btn btn-sm btn-primary">Editar</a>
                            <a href="#" class="btn btn-sm btn-danger">Excluir</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        {{ $pagamentos->links() }}
    </div>
    




@endsection
