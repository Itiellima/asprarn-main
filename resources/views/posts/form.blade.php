<form action="{{ $post->exists ? route('posts.update', $post->id) : route('posts.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf

    @if ($post->exists)
        @method('PUT')
    @endif

    <div class="container row mb-3">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Titulo da publicação</label>
            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Titulo"
                value="{{ old('titulo', $post->titulo ?? '') }}">
            @error('titulo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Assunto</label>
            <input type="text" class="form-control" id="assunto" name="assunto" placeholder="Assunto da publicação"
                value="{{ old('assunto', $post->assunto ?? '') }}">
            @error('assunto')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="formFile" class="form-label">Insira as fotos</label>
            <input class="form-control" type="file" id="img" name="arquivos[]" multiple
                {{ $post->exists ? '' : 'required' }}>

            @if ($post->exists && $post->files)
                <div class="mt-2 d-flex gap-2 flex-wrap">
                    @foreach ($post->files as $file)
                        <img src="{{ $file->url }}" width="120">
                    @endforeach
                </div>
            @endif
            
        </div>

        <div class="mb-3 col-3">
            <label for="exampleFormControlInput1" class="form-label">Data de referencia</label>
            <input type="date" class="form-control" id="data" name="data" placeholder="Data de inicio"
                value="{{ old('data', $post->data ? $post->data->format('Y-m-d') : '') }}">
            @error('data')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Texto do Post</label>
            <textarea id="editor" class="form-control" id="texto" name="texto" rows="3"
                placeholder="Insira o texto do post aqui">{{ old('texto', $post->texto ?? '') }}</textarea>
            @error('texto')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">
            {{ $post->exists ? 'Salvar Alterações' : 'Criar Publicação' }}
        </button>

    </div>
</form>



{{-- scripts --}}
{{-- preview de foto/imagem  --}}
<script>
    document.getElementById('img').addEventListener('change', function(event) {
        const container = document.getElementById('preview-container');
        container.innerHTML = ''; // Limpa previews anteriores

        Array.from(event.target.files).forEach(file => {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.width = 120;
            img.classList.add('me-2', 'mb-2');
            container.appendChild(img);
        });
    });
</script>
