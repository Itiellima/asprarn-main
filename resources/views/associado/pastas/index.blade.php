@extends('layouts.main')

@section('title', 'Aspra Associado')

@section('content')

    <div class="container">

        <div class="container m-3 p-3 border rounded">
            {{-- Titulo da pagina --}}
            <h2>
                Documentos de {{ $associado->nome }}
            </h2>

        </div>
        
        <div class="container m-3 p-3 border rounded">
            @if ($pastas && $pastas->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome da Pasta</th>
                            <th>Tipo de Documento</th>
                            <th>Descrição</th>
                            <th>Criado em</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pastas as $pasta)
                            <tr>
                                <td>{{ $pasta->nome }}</td>
                                <td>{{ $pasta->tipo_documento }}</td>
                                <td>{{ $pasta->descricao }}</td>
                                <td>{{ date('d/m/Y', strtotime($pasta->created_at)) }}</td>
                                <td>
                                    <a href="{{ route('associado.pasta_documento.show', ['associado_id' => $associado->id, 'pasta_id' => $pasta->id]) }}"
                                    class="btn btn-primary btn-sm">Ver Pasta</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @endif
        </div>

        {{-- Modal crirar pasta --}}
        <div>
            {{-- Botão para abrir modal de inderir documento --}}
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Nova Pasta
            </button>

            {{-- Modal de criar pasta --}}
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h3>Documentos de {{ $associado->nome }}</h3>

                            {{-- Formulário de criacao de pasta --}}
                            <form action="{{ route('associado.pasta_documento.store', $associado->id) }}" method="POST">
                                @csrf

                                <label>Nome da pasta</label>
                                <input type="text" class="form-control" name="nome" required>

                                <label>Tipo de Documento</label>
                                <input type="text" class="form-control" name="tipo_documento">

                                <label>Observação</label>
                                <textarea class="form-control" name="descricao"></textarea>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                                    <button type="submit" class="btn btn-primary">Inserir</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>





@endsection
