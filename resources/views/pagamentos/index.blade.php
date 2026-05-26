@extends('layouts.main')

@section('title', 'AspraRN - Pagamentos')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container mb-3">
        <div class="alert alert-light text-black text-center">
            <h4>
                Listar pagamentos
            </h4>
        </div>
        <form action="{{ route('pagamentos.index') }}" method="GET">
            <input type="text" id="search" name="search" class="form-control" placeholder="Pesquise por Associado ou CPF"
            value="{{ request('search') }}">
        </form>
    </div>

    <div class="container">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Data de pagamento</th>
                    <th scope="col">Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pagamentos as $pg)
                <tr>
                    <th scope="row">{{ $pg->id }}</th>
                    <td>{{ $pg->associado->nome }}</td>
                    <td>{{ $pg->associado->cpf }}</td>
                    <td>{{ date('d/m/Y', strtotime($pg->data_pagamento)) }}</td>
                    <td>{{ $pg->valor }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $pagamentos->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

    {{-- {{ $pagamentos->links() }} --}}













@endsection
