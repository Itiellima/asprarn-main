<form action="{{ $beneficio->exists ? route('beneficio.update', $beneficio->id) : route('beneficio.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if ($beneficio->exists)
        @method('PUT')
    @endif

    <div class="mb-3">

        <div class="mb-3">
            <label for="nome" class="form-label">Beneficio</label>
            <input type="text" class="form-control" id="nome" name="nome"
                placeholder="Example input placeholder" value="{{ old('nome', $beneficio->nome ?? '' ) }}">
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao"
                placeholder="Insira a descrição do beneficio" value="{{ old('descricao', $beneficio->descricao ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="img" class="form-label">Adicione uma imagem</label>
            <input class="form-control" type="file" id="img" name="arquivos[]" multiple>
        </div>

        <button class="btn btn-primary" type="submit">
            {{ $beneficio->exists ? 'Salvar alteraçções' : "Criar beneficio" }}
        </button>

    </div>

</form>
