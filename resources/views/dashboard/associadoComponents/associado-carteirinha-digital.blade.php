{{-- Carteirinha digital --}}
<div class="container mb-3">
    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white py-2">
            <strong>Carteirinha digital</strong>
        </div>

        <div class="card-body">

            <div class="row align-items-center g-3">

                {{-- Foto --}}
                <div class="col-md-4 text-center">
                    @if ($associado->pictureProfile?->path)
                        <img src="{{ asset('storage/' . $associado->pictureProfile->path) }}"
                             alt="Foto de perfil"
                             class="rounded shadow"
                             style="height: 180px; max-width: 100%; object-fit: contain;">
                    @else
                        <i class="bi bi-person-bounding-box text-secondary"
                           style="font-size: 120px;"></i>
                    @endif
                </div>

                {{-- Dados --}}
                <div class="col-md-8">
                    <div class="mb-2">
                        <small class="text-muted">Nome</small>
                        <div class="fw-semibold">{{ $associado->nome }}</div>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">CPF</small>
                        <div>{{ $associado->cpf }}</div>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">Data de nascimento</small>
                        <div>
                            {{ \Carbon\Carbon::parse($associado->dt_nasc)->format('d/m/Y') }}
                        </div>
                    </div>

                    <small class="text-muted">
                        Associação dos Praças da Polícia Militar do Rio Grande do Norte
                        (ASPRA PM/RN)
                    </small>
                </div>

            </div>

            {{-- Ações --}}
            <div class="d-flex flex-wrap gap-2 mt-3 pt-3 border-top">

                <a class="btn btn-sm btn-primary"
                   @if ($associado->pictureProfile)
                       href="{{ route('carteira-associados', $associado->id) }}"
                       target="_blank"
                   @else
                       onclick="alert('Faça o upload de uma foto para baixar a carteirinha')"
                   @endif>
                    <i class="bi bi-download"></i> Download
                </a>

                <a class="btn btn-sm btn-primary"
                   @if ($associado->pictureProfile)
                       href="{{ route('carteira-associados-vertical', $associado->id) }}"
                       target="_blank"
                   @else
                       onclick="alert('Faça o upload de uma foto para visualizar a carteirinha')"
                   @endif>
                    <i class="bi bi-eye"></i> Visualizar
                </a>

                <button type="button"
                        class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#pictureModal">
                    <i class="bi bi-camera"></i>
                    {{ $associado->pictureProfile ? 'Editar foto' : 'Adicionar foto' }}
                </button>

                @if ($associado->pictureProfile)
                    <form action="{{ route('associado.picture-profile.destroy', $associado->id) }}"
                          method="POST" class="m-0">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Deseja remover essa foto?')">
                            <i class="bi bi-trash"></i> Excluir foto
                        </button>
                    </form>
                @endif

                <a href="{{ route('validar-carteirinha', $associado->id) }}"
                   class="btn btn-sm btn-warning"
                   target="_blank">
                    <i class="bi bi-shield-check"></i> Validar
                </a>

            </div>
        </div>
    </div>
</div>