<div class="container alert alert-light text-black">
        <h2 class="text-center mb-4">Dados cadastrais</h2>

        <div class="border rounded shadow-sm">
            <div class="row m-3">

                {{-- COLUNA ESQUERDA --}}
                <div class="col-md-6">
                    <div class="form-control mb-3 bg-white">
                        <strong>Nome:</strong> {{ $associado->nome }}
                    </div>

                    <div class="form-control mb-3 bg-white">
                        <strong>CPF:</strong> {{ $associado->cpf }}
                    </div>

                    <div class="form-control mb-3 bg-white">
                        <strong>RG:</strong> {{ $associado->rg }}
                    </div>

                    <div class="form-control mb-3 bg-white">
                        <strong>Órgão Expedidor:</strong> {{ $associado->org_expedidor }}
                    </div>
                </div>

                {{-- COLUNA DIREITA --}}
                <div class="col-md-6">
                    <div class="form-control mb-3 bg-white">
                        <strong>Telefone:</strong> {{ $associado->contato->tel_celular ?? 'Não informado' }}
                    </div>

                    <div class="form-control mb-3 bg-white">
                        <strong>Data de Nascimento:</strong> {{ date('d/m/Y', strtotime($associado->dt_nasc)) }}
                    </div>

                    <div class="form-control mb-3 bg-white">
                        <strong>Email:</strong> {{ $associado->contato->email ?? 'Não informado' }}
                    </div>

                    {{-- BOTÕES --}}
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <a href="{{ route('associado.edit', $associado->id) }}" class="btn btn-primary w-100">Ver
                                mais</a>
                        </div>

                        <div class="col-md-6">
                            <div class="dropdown w-100">
                                <button class="btn btn-primary dropdown-toggle w-100" data-bs-toggle="dropdown">
                                    Gerar PDF
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('associado.pdf.requerimento', $associado->id) }}"
                                            target="_blank">Requerimento</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('associado.pdf.sesc', $associado->id) }}"
                                            target="_blank">Declaração SESC</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('associado.pdf.unp', $associado->id) }}"
                                            target="_blank">Declaração UNP</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('associado.pdf.declaracao', $associado->id) }}"
                                            target="_blank">Declaração Genérica</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('associado.pdf.desfiliacao', $associado->id) }}"
                                            target="_blank">Req. de Desfiliação</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>