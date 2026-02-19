<div class="container alert alert-light text-black text-center">

    <strong class="text-black">
        <h2>OPMs</h2>
    </strong>

    <div class="row content-center justify-content-center">
        @foreach ($opms as $opm)
            <div class="alert alert-light m-1 p-1" style="background-color: white; color: black;">
                <strong>
                    {{ $opm->nome }}
                </strong>
            </div>
            <form action="{{ route('opms.destroy', $opm->id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Deseja excluir essa situação?')">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
            </form>
        @endforeach
    </div>


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        INSERIR NOVA OPM
    </button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Nova OPM</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('opms.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <input type="text" name="nome" id="nome" class="form-control"
                            placeholder="Nome da OPM">
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
