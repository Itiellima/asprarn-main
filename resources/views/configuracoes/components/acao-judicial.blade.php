<div class="container alert alert-light text-black text-center">
    <div class="text-center">
        <h1>Ações judiciais</h1>
    </div>

    {{-- btn nova acao judicial --}}
    <div class="mb-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAcao">
            Nova ação judicial
        </button>

        <!-- Modal -->
        <div class="modal fade" id="createAcao" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="createAcaoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createAcaoLabel">Nova ação judicial</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('acao-judicial.store') }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="modal-body">
                            <label for="nome"><strong>Nome:</strong></label>
                            <input type="text" class="form-control" id="nome" name="nome" required
                                oninput="this.value = this.value.toUpperCase();">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row content-center justify-content-center">
        @foreach ($acoes as $acao)
            <form class="col-sm-6 col-md-4 col-lg-3" action="{{ route('acao-judicial.destroy', $acao->id) }}"
                method="POST" onsubmit="return confirm('Deseja excluir essa ação judicial?')">
                @csrf
                @method('DELETE')
                <div class="alert alert-light text-black m-2 p-2" style="background-color: white; color: black;">
                    <strong>
                        <label>{{ $acao->nome }}</label>
                    </strong>
                    <hr>
                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalEdit{{ $acao->id }}">
                        Editar
                    </button>
                </div>
            </form>

            <!-- Modal Editar -->
            <div class="modal fade" id="modalEdit{{ $acao->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="modalEditLabel{{ $acao->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalEditLabel{{ $acao->id }}">Editar ação judicial
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form action="{{ route('acao-judicial.update', $acao->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <label for="nome"><strong>Nome:</strong></label>
                                <input type="text" class="form-control" id="nome" name="nome" required
                                    value="{{ $acao->nome }}" oninput="this.value = this.value.toUpperCase();">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createAcao" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createAcaoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createAcaoLabel">Nova ação judicial</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('acao-judicial.store') }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="modal-body">
                        <label for="nome"><strong>Nome:</strong></label>
                        <input type="text" class="form-control" id="nome" name="nome" required
                            oninput="this.value = this.value.toUpperCase();">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
