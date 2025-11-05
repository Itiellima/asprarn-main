@extends('layouts.main')

@section('title', 'Aspra Associado')

@section('content')
    @include('dashboard.layouts.nav-dashboard')

    <div class="container">

        <div class=" display-flex row justify-content align-center alert alert-light m-3 text-center">
            <h1 class="text-black">
                <strong>
                    Planos
                </strong>
            </h1>
            <hr>
            <h2>INSERIR NOVO PLANO</h2>
        </div>

        <div class="container mb-3">

            <form action="{{ $plano->exists ? route('planos.update', $plano->id) : route('planos.store') }}" method="POST">
                @csrf
                @if ($plano->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Plano</label>
                    <input type="text" class="form-control" id="nome" name="nome" required
                        value="{{ old('nome', $plano->nome ?? '') }}">
                </div>

                @if ($plano->exists)
                    @foreach ($plano->beneficios as $beneficio)
                        <div id="add-container">
                            <div class="mb-3 add">
                                <label for="beneficios" class="form-label">Beneficio</label>
                                <textarea class="form-control" name="beneficios[]" rows="3" required>{{ old('beneficios[]', $beneficio) }}</textarea>
                                <button type="button" class="btn btn-sm btn-danger mt-1 remove-beneficios">Remover</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary mb-3" id="add">+ Adicionar Beneficio</button>
                    @endforeach
                @else
                    <div id="add-container">
                        <div class="mb-3 add">
                            <label for="beneficios" class="form-label">Beneficio</label>
                            <textarea class="form-control" id="beneficios" name="beneficios[]" rows="3" required></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mb-3" id="add">+ Adicionar Beneficio</button>
                @endif


                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" required
                        value="{{ old('descricao', $plano->descricao ?? '') }}">
                </div>
                <div class="mb-3">
                    <label for="preco" class="form-label">Preço</label>
                    <input type="number" step="0.01" class="form-control" id="preco" name="preco" required
                        value="{{ old('preco', $plano->preco ?? '') }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ $plano->exists ? 'Atualizar plano' : 'Criar plano' }}
                </button>
            </form>
        </div>
    </div>

    @include('planos.card-plano')

    <script>
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-beneficios')) {
                e.target.closest('.add').remove();
            }
        });

        document.getElementById('add').addEventListener('click', function() {
            const container = document.getElementById('add-container');
            const newField = document.createElement('div');
            newField.classList.add('mb-3', 'add');
            newField.innerHTML = `
            <label class="form-label">Benefício</label>
            <textarea class="form-control" name="beneficios[]" rows="3" required></textarea>
            <button type="button" class="btn btn-sm btn-danger mt-1 remove-beneficios">Remover</button>
        `;
            container.appendChild(newField);
        });
    </script>

@endsection
