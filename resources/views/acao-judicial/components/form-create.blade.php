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
                            <input type="text" class="form-control" id="nome" name="nome" required oninput="this.value = this.value.toUpperCase();">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>