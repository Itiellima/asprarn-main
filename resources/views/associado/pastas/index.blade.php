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


        @if ($pastas && $pastas->count() > 0)
            <div class="container mb-3">
                <div class="row g-2">

                    @foreach ($pastas as $pasta)
                        <div class="col-6 col-md-4 col-lg-3 col-xl-2 d-flex">

                            <a href="{{ route('associado.pasta.show', ['associadoId' => $associado->id, 'pastaId' => $pasta->id]) }}"
                                class="text-decoration-none text-dark w-100">

                                <div class="card h-100 shadow-sm d-flex flex-column"
                                    style="cursor:pointer; min-height: 160px;">

                                    <div class="card-img-top text-center mt-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60"
                                            fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16">
                                            <path
                                                d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a2 2 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139q.323-.119.684-.12h5.396z" />
                                        </svg>
                                    </div>

                                    <div class="card-body text-center d-flex flex-column">
                                        <h6 class="card-title">{{ $pasta->nome }}</h6>
                                    </div>

                                    <div class="card-footer text-center mt-auto">
                                        <form
                                            action="{{ route('associado.pasta.destroy', ['associadoId' => $associado->id, 'pastaId' => $pasta->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Deseja excluir essa pasta?')">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </a>

                        </div>
                    @endforeach

                </div>

            </div>
        @endif

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
                            <form action="{{ route('associado.pasta.store', ['associadoId' => $associado->id]) }}"
                                method="POST">
                                @csrf

                                <label>Nome da pasta</label>
                                <input type="text" class="form-control" name="nome" required>

                                {{-- <label>Tipo de Documento</label>
                                <input type="text" class="form-control" name="tipo_documento">

                                <label>Observação</label>
                                <textarea class="form-control" name="descricao"></textarea> --}}

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
