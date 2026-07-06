@extends('financeiro.components.layout')

@section('financeiro-content-header')
    Contas a pagar
@endsection

@section('financeiro-content')
    <div class="container rounded">
        <a href="{{ route('contas-a-pagar.create') }}" class="btn btn-primary">
            Nova conta a pagar
        </a>
    </div>
    <div class="card-body">
        Seu conteúdo financeiro aqui.
    </div>
@endsection
