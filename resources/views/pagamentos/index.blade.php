@extends('layouts.main')

@section('title', 'AspraRN - Bem vindo')

@section('content')

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
