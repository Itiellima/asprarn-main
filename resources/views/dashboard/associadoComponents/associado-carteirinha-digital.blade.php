        {{-- Aba carteirinha digital --}}
        <div class="alert alert-light text-black">
            <h4 class="text-black">Carteirinha digital</h4>
            <div class="row mt-3 mb-3">

                <div class="col-md-6 mb-3 mt-3 d-flex align-items-center justify-content-center">
                    <div class="row d-flex align-items-center justify-content-center">
                        <div class="justify-content-center d-flex align-items-center">
                            @if ($associado->pictureProfile?->path)
                                <img src="{{ asset('storage/' . $associado->pictureProfile->path) }}" alt="Foto de perfil"
                                    class="rounded shadow" width="auto" height="200px" style="object-fit: contain;">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150"
                                    fill="currentColor" class="bi bi-person-bounding-box" viewBox="0 0 16 16">
                                    <path
                                        d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5" />
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <ul>
                        <li>Nome: {{ $associado->nome }}</li>
                        <li>CPF: {{ $associado->cpf }}</li>
                        <li>RG: {{ $associado->rg }}</li>
                        <li>Org. Expedidor: {{ $associado->org_expedidor }}</li>
                        <li>Categoria: </li>
                        <li>Plano: </li>
                        <li>Associação dos Praças da Polícia Militar do Rio Grande do Norte (ASPRA PM/RN)</li>
                    </ul>
                </div>
            </div>


            <div class="d-flex flex-wrap gap-2 mt-2">

                <button class="btn btn-sm btn-primary">
                    📝 Emitir carteirinha
                </button>

                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#pictureModal">
                    Editar foto
                </button>

                <form action="{{ route('associado.picture-profile.destroy', $associado->id) }}" method="POST"
                    class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Deseja remover essa foto?')">
                        Excluir foto
                    </button>
                </form>

            </div>

            <!-- Modal -->
            <div class="modal fade" id="pictureModal" tabindex="-1" aria-labelledby="pictureModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('associado.picture-profile.store', $associado->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="pictureModalLabel">Nova foto</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                Selecione uma nova foto de perfil:
                                <input type="file" class="form-control mt-3" name="picture_profile">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
