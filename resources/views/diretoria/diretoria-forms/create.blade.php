@extends('diretoria.components.layout')

@section('diretoria-content')
    <div class="container">

        <div class="card shadow-sm">

            <div class="card-header">
                <h4 class="mb-0">Cadastrar Diretoria</h4>
            </div>

            <div class="card-body">

                <form action="{{ route('diretoria.store') }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="mb-3">
                        <label for="nome" class="form-label">
                            Nome da Diretoria
                        </label>

                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome"
                            name="nome" value="{{ old('nome') }}" placeholder="Ex: Diretoria Executiva" required>

                        @error('nome')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sigla" class="form-label">
                            Sigla
                        </label>

                        <input type="text" class="form-control @error('sigla') is-invalid @enderror" id="sigla"
                            name="sigla" value="{{ old('sigla') }}" placeholder="Ex: DIREX" maxlength="20"
                            oninput="this.value = this.value.toUpperCase()" required>

                        @error('sigla')
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

                            <option value="ativo" {{ old('status') == 'ativo' ? 'selected' : '' }}>
                                Ativo
                            </option>

                            <option value="inativo" {{ old('status') == 'inativo' ? 'selected' : '' }}>
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

                        <a href="{{ route('diretoria.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Salvar Diretoria
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
