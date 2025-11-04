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
            {{-- {{ route('planos.store') }} --}}
            <form action="" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Plano</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>

                <div id="add-container">
                    <div class="mb-3 add">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao[]" rows="3" required></textarea>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" id="add">+ Adicionar descricao</button>

                <div class="mb-3">
                    <label for="preco" class="form-label">Preço</label>
                    <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
                </div>

                <button type="submit" class="btn btn-primary">Criar Plano</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add').addEventListener('click', function() {
            const container = document.getElementById('add-container');
            const newField = document.createElement('div');
            newField.classList.add('mb-3', 'add');
            newField.innerHTML = `
        <label class="form-label">Descrição</label>
        <textarea class="form-control" name="descricao[]" rows="3" required></textarea>
        <button type="button" class="btn btn-sm btn-danger mt-1 remove-descricao">Remover</button>
        `;
            container.appendChild(newField);

            newField.querySelector('.remove-descricao').addEventListener('click', function() {
                newField.remove();
            });
        });
    </script>

@endsection
