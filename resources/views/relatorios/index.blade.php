@extends('layouts.main')

@section('title', 'AspraRN - Bem vindo')

@section('content')


    <div class="container body-offset">

        <div class="meu-container alert alert-light text-black text-center">
            <h1>
                Relatórios
            </h1>
        </div>

        <div class="container text-center">
            <h2>
                Selecionar filtros para gerar o relatório:
            </h2>
        </div>

        <form action="{{ route('relatorios.gerar.todos') }}" method="GET" target="_blank">
            
            <div class="col-md-2 mb-3">
                <label class="form-label"><strong>Situação</strong></label>
                <select name="situacao_id" class="form-select">

                    <option value="">Todos</option>

                    @foreach ($situacoes as $situacao)
                        <option value="{{ $situacao->id }}"
                            {{ request('situacao_id') == $situacao->id ? 'selected' : '' }}>
                            {{ strtoupper($situacao->nome) }}
                        </option>
                    @endforeach

                </select>
            </div>

            <button type="submit" class="btn btn-primary">Gerar Relatório</button>

        </form>





    @endsection
