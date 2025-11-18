@extends('layouts.main')

@section('title', 'Banners - ASPRA - RN')

@section('content')

    <div class="container">

        <form action="{{ route('banner.store') }}" enctype="multipart/form-data" method="POST">
            @csrf

            @if ($banner->exists)
                @method('PUT')
            @endif

            <div class="container row mb-3">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Titulo do Banner</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Titulo"
                        value="{{ old('titulo', $banner->titulo ?? '') }}">
                    @error('titulo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Insira as fotos</label>
                    <input class="form-control" type="file" id="img" name="arquivos" multiple
                        {{ $banner->exists ? '' : 'required' }}>
                </div>

                <button type="submit" class="btn btn-success">
                    {{ $banner->exists ? 'Salvar Alterações' : 'Criar Publicação' }}
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
    </div>


    <div class="meu-container">

        @foreach ($AllBanners as $banner)
            <div class="card m-1 rounded-5 overflow-hidden p-0" style="width: 20rem;">

                <img src="{{ asset('storage/' . $banner->files->first()->path) }}" class="card-img-top"
                    style="height: 200px; width: 100%; object-fit: cover;" alt="{{ $banner->titulo }}">

                <div class="card-body">
                    <h5 class="card-title">{{ $banner->titulo }}</h5>
                </div>
                <div class="m-1">
                    <form action="{{ route('banner.destroy', $banner->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        
                        <button type="submit" class="btn btn-danger">Excluir</button>

                    </form>
                </div>

            </div>
        @endforeach


    </div>













@endsection
