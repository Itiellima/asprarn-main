<div class="container alert alert-light text-black text-center">

    <div class="row content-center justify-content-center">
        @foreach ($opms as $opm)
            {{ $opm->nome }}
            {{-- <form class="col-sm-6 col-md-4 col-lg-3" action="{{ route('opm.destroy', $opm->id) }}" method="POST"
                onsubmit="return confirm('Deseja excluir essa situação?')">
                @csrf
                @method('DELETE')
                <div class="alert alert-light text-black m-2 p-2">
                    <label class="">{{ $opm->nome }}</label>
                    <hr>
                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalEdit{{ $situacao->id }}">
                        Editar
                    </button>
                </div>
            </form> --}}
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
