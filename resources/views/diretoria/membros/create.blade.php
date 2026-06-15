@extends('diretoria.components.layout')

@section('diretoria-content')
    <div class="container">

        <div class="card shadow-sm">

            <div class="card-header">
                <h4 class="mb-0">Novo membro</h4>
            </div>

            <div class="card-body">

                <form
                    action="{{ $membro->exists ? route('diretoria.funcoes.update', $membro->id) : route('diretoria.membros.store') }}"
                    method="POST">
                    @csrf
                    @if ($membro->exists)
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif


                    <div class="mb-3">
                        <label for="associado" class="form-label">
                            Nome
                        </label>

                        <select class="form-select @error('associado') is-invalid @enderror" id="associado" name="associado"
                            required>

                            <option value="">Selecione um membro</option>

                            @foreach ($associados as $associado)
                                <option value="{{ $associado->id }}"
                                    {{ old('associado', $membro->associado_id ?? '') == $associado->id ? 'selected' : '' }}>
                                    {{ $associado->nome }} - {{ $associado->cpf }}
                                </option>
                            @endforeach

                        </select>

                        @error('associado')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>



                    <div class="mb-3">
                        <label for="diretoria" class="form-label">
                            Diretoria
                        </label>

                        <select class="form-select @error('diretoria') is-invalid @enderror" id="diretoria" name="diretoria"
                            required>

                            <option value="">Selecione</option>

                            @foreach ($diretorias as $diretoria)
                                <option value="{{ $diretoria->id }}"
                                    {{ old('diretoria', $diretoria_id ?? '') == $diretoria->id ? 'selected' : '' }}>
                                    {{ $diretoria->nome }}
                                </option>
                            @endforeach

                        </select>

                        @error('diretoria')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="funcao" class="form-label">
                            Função
                        </label>

                        <select class="form-select @error('funcao') is-invalid @enderror" id="funcao" name="funcao"
                            required>

                            <option value="">Selecione</option>

                            @foreach ($funcoes as $funcao)
                                <option value="{{ $funcao->id }}"
                                    {{ old('funcao', $funcao_id ?? '') == $funcao->id ? 'selected' : '' }}>
                                    {{ $funcao->nome }}
                                </option>
                            @endforeach

                        </select>

                        @error('funcao')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inicio_mandato">Inicio do mandato</label>
                                <input type="date" name="inicio_mandato" id="inicio_mandato" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="fim_mandato">Fim do mandato</label>
                                <input type="date" name="fim_mandato" id="fim_mandato" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('diretoria.membros.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary">
                            {{ $membro->exists ? 'Salvar alterações.' : 'Salvar novo membro.' }}
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    @push('scripts')
        {{-- busca por pesquisa --}}
        {{-- select2 --}}
        <script>
            $(document).ready(function() {

                $('#associado').select2({
                    placeholder: 'Digite nome ou CPF',
                    allowClear: true,
                    width: '100%'
                });

            });
        </script>

        {{-- select2 --}}
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
@endsection
