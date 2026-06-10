@extends('layouts.main')

@section('title', 'AspraRN - Diretoria')

@section('content')


    <div class="container mb-3">
        <div class="justify-content-center text-center">
            <a href="{{ route('diretoria.index') }}" class="btn btn-primary mb-3">Diretorias</a>
            <a href="{{ route('quadroDiretoria.index') }}" class="btn btn-primary mb-3">Quadro de diretorias</a>
            <a href="" class="btn btn-primary mb-3">Funções</a>
            <a href="" class="btn btn-primary mb-3">Membros</a>
        </div>
    </div>

    @yield('diretoria-content')



@endsection
