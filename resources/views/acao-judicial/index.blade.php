@extends('layouts.main')

@section('title', 'ASPRA RN - Ações judiciais')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    <div class="container">
        <div class="text-center">
            <h1>Ações judiciais</h1>
        </div>

        {{-- btn nova acao judicial --}}
        <div class="mb-3">
            @include('acao-judicial.components.form-create')
        </div>

        <div class="row justify-content-center">
            @foreach ($acoes as $acao)
                <div class="card m-3 col-md-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $acao->nome }}</h5>

                        <a href="" onclick="return confirm('Tem certeza que deseja excluir esta ação judicial?')">
                            Excluir
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-trash" viewBox="0 0 16 16">
                                <path
                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                <path
                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                            </svg>

                        </a>

                    </div>
                </div>
            @endforeach
        </div>




    </div>




@endsection
