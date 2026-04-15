@extends('layouts.main')

@section('title', 'AspraRN - Bem vindo')

@section('content')

    @include('dashboard.layouts.nav-dashboard')

    {{-- @if (session()->all())
        <pre>
        {{ print_r(session()->all(), true) }}
    </pre>
    @endif --}}

    @if (session('sucesso') !== null)
        <div class="alert alert-info">
            <strong>Resultado da importação:</strong><br>

            ✅ Sucesso: {{ session('sucesso') }}<br>
            ❌ Falhas: {{ session('falhas') }}
        </div>
    @endif

    {{-- @if (session('falhasDetalhes'))
        <div class="alert alert-danger mt-3">
            <strong>Detalhes das falhas:</strong>

            <ul class="mb-0">
                @foreach (session('falhasDetalhes') as $erro)
                    <li>
                        CPF: <strong>{{ $erro['cpf'] }}</strong> -
                        Nome: <strong>{{ $erro['nome'] }}</strong> -
                        Motivo:
                        {{ $erro['motivo'] }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    @if (session('falhasAgrupadas'))
        <div class="alert alert-danger mt-3">
            <strong>Detalhes das falhas:</strong>

            @foreach (session('falhasAgrupadas') as $motivo => $erros)
                <div class="mt-2">
                    <strong>{{ $motivo }} ({{ count($erros) }})</strong>

                    <ul>
                        @foreach ($erros as $erro)
                            <li>
                                <strong>CPF:</strong> {{ $erro['cpf'] }}
                                <strong>Nome:</strong> {{ $erro['nome'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    @endif


    <div class="container">
        <h1>Pagamentos</h1>
        <p>Bem-vindo à página de pagamentos!</p>

        <form action="{{ route('pagamentos.readArchive') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="arquivo" class="form-label">Selecione o arquivo de pagamentos:</label>
                <input type="file" class="form-control" id="arquivo" name="arquivo" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>


    <div class="container">

        @if (empty($dadosCsv))
            <p>Nenhum dado disponível.</p>
        @else
            <div class="alert alert-dark mt-3">
                <form action="{{ route('pagamentos.processar') }}" method="POST">
                    @csrf

                    <input type="hidden" name="dados" value='@json($dadosCsv)'>
                    <button type="submit" class="btn btn-primary mt-3 mb-3">
                        Confirmar importação
                    </button>
                    <div class="form-group">
                        <label for="observacao" class="form-label text-black">Observação (opcional):</label>
                        <input type="text" name="observacao" id="observacao" class="form-control mb-2"
                            placeholder="Observação (opcional)">
                        <label for="data_pagamento" class="form-label text-black">Data de pagamento:</label>
                        <input type="date" name="data_pagamento" id="data_pagamento" class="form-control mb-2"
                            placeholder="Data de pagamento">
                    </div>
                </form>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Matrícula</th>
                        <th>Valor</th>
                        <th>Mês referencia</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($dadosCsv as $linha)
                        <tr>
                            <td>{{ $linha['nome'] }}</td>
                            <td>{{ $linha['cpf'] }}</td>
                            <td>{{ $linha['matricula'] }}</td>
                            <td>{{ $linha['valor'] }}</td>
                            <td>{{ $linha['mes_referencia'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>





@endsection
