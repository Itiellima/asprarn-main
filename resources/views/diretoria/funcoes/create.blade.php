@extends('diretoria.components.layout')

@section('diretoria-content')
    <div class="container">

        <div class="card shadow-sm">

            <div class="card-header">
                <h4 class="mb-0">Cadastrar Função</h4>
            </div>

            <div class="card-body">

                <form
                    action="{{ $funcao->exists ? route('diretoria.update', $funcao->id) : route('diretoria.funcoes.store') }}"
                    method="POST">
                    @csrf
                    @if ($funcao->exists)
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif


                    <div class="mb-3">
                        <label for="nome" class="form-label">
                            Nome
                        </label>

                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome"
                            name="nome" value="{{ old('nome', $funcao->nome ?? '') }}"
                            placeholder="Ex: Presidente" required autofocus>

                        @error('nome')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">
                            Descricao
                        </label>

                        <input type="text" class="form-control @error('descricao') is-invalid @enderror" id="descricao"
                            name="descricao" value="{{ old('descricao', $funcao->descricao ?? '') }}" placeholder="Ex: Descrição da função"
                            maxlength="255" required>

                        @error('descricao')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">
                            Status
                        </label>

                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            required>

                            <option value="">Selecione</option>

                            <option value="ativo"
                                {{ old('status', $funcao->status ?? '') == 'ativo' ? 'selected' : '' }}>
                                Ativo
                            </option>

                            <option value="inativo"
                                {{ old('status', $funcao->status ?? '') == 'inativo' ? 'selected' : '' }}>
                                Inativo
                            </option>

                        </select>

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('diretoria.funcoes.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Salvar Função
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
