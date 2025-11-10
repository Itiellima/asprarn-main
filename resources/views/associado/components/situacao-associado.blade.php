{{-- situacao --}}
<div class="container alert alert-light text-black text-center">
    
    <strong class="text-black">
        <h2>Situação do associado</h2>
    </strong>

    <form action="{{ route('situacao.update', $associado->id) }}" method="POST">
        @csrf

        @foreach ($situacoes as $situacao)
            <div class="form-check form-check-inline">
                <input 
                class="form-check-input" 
                type="checkbox" 
                id="situacao_{{ $situacao->id }}" 
                name="situacoes[]"
                value="{{ $situacao->id }}" {{ $associado->situacoes->contains($situacao->id) ? 'checked' : '' }}>

                <label class="form-check-label" for="situacao_{{ $situacao->id }}">
                    {{ $situacao->nome }}
                </label>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-3 mb-3">Salvar</button>

    </form>
<p></p>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Nova situação
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('situacao.store') }}" method="POST">
                        @csrf

                        <label for="nome"> Nome da situacao</label>
                        <input type="text" name="nome" id="nome" class="form-control" placeholder="Situação">

                        <hr>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                        <button type="submit" class="btn btn-primary mt-3 mb-3">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>









</div>
