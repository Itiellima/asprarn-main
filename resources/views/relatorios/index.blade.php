@extends('layouts.main')

@section('title', 'AspraRN - Bem vindo')

@section('content')


    <div class="container body-offset">

        <div class="meu-container alert alert-light text-black text-center">
            <h1>
                Relatórios
            </h1>
        </div>

        <div class="container mb-3">

            <a href="{{ route('relatorios.gerar.todos') }}" class="btn btn-primary"> + Imprimir relatorio completo de associados</a>
            
            <a href="#" class="btn btn-success"> + Imprimir relatorio de associados ativos</a>
        </div>


        







@endsection