@extends('layouts.main')

@section('title', 'AspraRN - Diretoria')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <hr>
    <div class="container mb">
        <div class="justify-content-center text-center">
            <a href="{{ route('diretoria.index') }}" class="btn btn-primary mb-3">Diretorias</a>
            <a href="{{ route('diretoria.funcoes.index') }}" class="btn btn-primary mb-3">Funções</a>
            <a href="{{ route('diretoria.membros.index') }}" class="btn btn-primary mb-3">Membros</a>
        </div>
    </div>

    @yield('diretoria-content')



@endsection
