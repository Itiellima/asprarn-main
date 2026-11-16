@extends('layouts.main')

@section('title', 'Aspra Associado')

@section('content')


    <div class="container">
        <h2>Mostrando pasta:</h2>
        <h2>{{ $pasta->nome }}</h2>
    </div>

    {{-- MODAL INSERSAO --}}
    <div class="container">
        {{-- Botão para abrir modal de inderir documento --}}
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            + Novo arquivo
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark"
                viewBox="0 0 16 16">
                <path
                    d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z" />
            </svg>
        </button>
        <a href="{{ route('associado.pasta.index', $associado->id) }}" class="btn btn-secondary mb-3">
            Voltar
        </a>

        {{-- Modal de inserir documento --}}
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Enviar documento</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3>Documentos de {{ $associado->nome }}</h3>

                        {{-- Formulário de envio documento --}}
                        <form action="{{ route('associado.pasta.documentos.store', ['pastaId' => $pasta->id]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <label>Arquivo: PDF, JPG ou PNG, até 10 MB.</label>
                            <input class="form-control" type="file" name="arquivo" required>

                            <label>Observação</label>
                            <textarea class="form-control" name="observacao"></textarea>

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

    <div class="container">
        {{-- Busca por nome do arquivo, status ou observação --}}
        <form method="GET" action="{{ route('associado.pasta.show', [$associado->id, $pasta->id]) }}" class="d-flex gap-2 mb-3">
            <input type="text" name="search" class="form-control" placeholder="Buscar por arquivo, status ou observação"
                value="{{ $search }}">
            <button type="submit" class="btn btn-primary">Buscar</button>
            @if ($search)
                <a href="{{ route('associado.pasta.show', [$associado->id, $pasta->id]) }}" class="btn btn-secondary">Limpar</a>
            @endif
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Arquivo</th>
                    <th>Status</th>
                    <th>Observação</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($documentos as $file)
                    <tr>
                        <td>{{ $file->tipo_documento }}</td>
                        <td>{{ ucfirst($file->status) }}</td>
                        <td>{{ $file->observacao }}</td>
                        <td>
                            <a href="{{ route('associado.pasta.documentos.show', ['pastaId' => $pasta->id, 'fileId' => $file->id]) }}"
                                class="btn btn-sm btn-primary" target="_blank">
                                Visualizar
                            </a>
                            {{-- Botão para abrir modal de edição --}}
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalEditDocumento{{ $file->id }}">
                                Editar
                            </button>

                            {{-- Modal de edição --}}
                            <div class="modal fade" id="modalEditDocumento{{ $file->id }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel{{ $file->id }}"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title fs-5" id="modalLabel{{ $file->id }}">
                                                Editar documento: {{ $file->tipo_documento }}
                                            </h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Fechar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('associado.documentos.update', ['pastaId' => $pasta->id, 'fileId' => $file->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-3">
                                                    <label>Status</label>
                                                    <select class="form-control" name="status">
                                                        <option value="pendente"
                                                            {{ $file->status == 'pendente' ? 'selected' : '' }}>
                                                            Pendente</option>
                                                        <option value="recebido"
                                                            {{ $file->status == 'recebido' ? 'selected' : '' }}>
                                                            Recebido</option>
                                                        <option value="rejeitado"
                                                            {{ $file->status == 'rejeitado' ? 'selected' : '' }}>
                                                            Rejeitado</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Observação</label>
                                                    <input class="form-control" type="text" name="observacao"
                                                        value="{{ $file->observacao }}" placeholder="Observação">
                                                </div>
                                                <button class="btn btn-success" type="submit">Atualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Formulário de exclusão --}}
                            <form
                                action="{{ route('associado.pasta.documentos.destroy', ['pastaId' => $pasta->id, 'fileId' => $file->id]) }}"
                                method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit"
                                    onclick="return confirm('Tem certeza que deseja excluir este documento?')">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">
                            {{ $search ? 'Nenhum documento encontrado para essa busca.' : 'Nenhum documento nesta pasta.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $documentos->links('pagination::bootstrap-5') }}
    </div>

@endsection
