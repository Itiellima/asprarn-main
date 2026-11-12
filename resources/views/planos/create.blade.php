@extends('layouts.main')

@section('title', 'Aspra Associado')

@section('content')
    @include('dashboard.layouts.nav-dashboard')

    @php
        // Depois de um erro de validação, volta o que foi digitado; senão, o que está salvo
        $beneficios = old('beneficios', $plano->beneficios ?? []) ?: [''];
        $preco = old('preco', $plano->exists ? number_format($plano->preco, 2, ',', '.') : '');
    @endphp

    <div class="container">

        <div class=" display-flex row justify-content align-center alert alert-light m-3 text-center">
            <h1 class="text-black">
                <strong>
                    Planos
                </strong>
            </h1>
            <hr>
            <h2>{{ $plano->exists ? 'EDITAR PLANO' : 'INSERIR NOVO PLANO' }}</h2>
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

                <div id="add-container">
                    @foreach ($beneficios as $beneficio)
                        <div class="mb-3 add">
                            <label class="form-label">Benefício</label>
                            <textarea class="form-control" name="beneficios[]" rows="3" required>{{ $beneficio }}</textarea>
                            <button type="button" class="btn btn-sm btn-danger mt-1 remove-beneficios">Remover</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-secondary mb-3" id="add">+ Adicionar Benefício</button>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" required
                        value="{{ old('descricao', $plano->descricao ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="preco" class="form-label">Valor</label>
                    <input type="text" class="form-control" id="preco" name="preco" required inputmode="numeric"
                        value="{{ $preco }}">
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
                // Mantém pelo menos um campo de benefício na tela
                if (document.querySelectorAll('#add-container .add').length > 1) {
                    e.target.closest('.add').remove();
                }
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
    <script>
        document.getElementById('preco').addEventListener('input', function(e) {
            let valor = e.target.value.replace(/\D/g, '');

            valor = (valor / 100).toFixed(2) + '';
            valor = valor.replace('.', ',');
            valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            e.target.value = valor;
        });
    </script>

@endsection
