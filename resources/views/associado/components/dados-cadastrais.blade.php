<div class="container py-3">
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h4 class="text-center mb-3">Dados cadastrais</h4>

            <div class="row g-2">
                <div class="col-md-6">
                    <div class="border rounded p-2">
                        <small class="text-muted">Nome</small>
                        <div class="fw-semibold">{{ $associado->nome }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded p-2">
                        <small class="text-muted">CPF</small>
                        <div>{{ $associado->cpf }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded p-2">
                        <small class="text-muted">RG</small>
                        <div>{{ $associado->rg }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded p-2">
                        <small class="text-muted">Órgão Expedidor</small>
                        <div>{{ $associado->org_expedidor }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded p-2">
                        <small class="text-muted">Telefone</small>
                        <div>{{ $associado->contato->tel_celular ?? 'Não informado' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded p-2">
                        <small class="text-muted">Nascimento</small>
                        <div>{{ $associado->dt_nasc ? date('d/m/Y', strtotime($associado->dt_nasc)) : 'Não informado' }}
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="border rounded p-2">
                        <small class="text-muted">Email</small>
                        <div>{{ $associado->contato->email ?? 'Não informado' }}</div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('associado.edit', $associado->id) }}" class="btn btn-primary flex-fill">
                    Ver mais
                </a>

                <div class="dropdown flex-fill">
                    <button class="btn btn-secondary dropdown-toggle w-100" data-bs-toggle="dropdown">
                        PDF
                    </button>

                    <ul class="dropdown-menu w-100">
                        <li><a class="dropdown-item"
                                href="{{ route('associado.pdf.requerimento', $associado->id) }}" target="_blank">Requerimento</a></li>
                        <li><a class="dropdown-item" href="{{ route('associado.pdf.sesc', $associado->id) }}" target="_blank">SESC</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('associado.pdf.unp', $associado->id) }}" target="_blank">UNP</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{ route('associado.pdf.declaracao', $associado->id) }}" target="_blank">Declaração</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('associado.pdf.desfiliacao', $associado->id) }}" target="_blank">Desfiliação</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('associado.pdf.termo-de-adesao-acp', $associado->id) }}" target="_blank">Termo de Adesão
                                ACP</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('associado.pdf.beneficiarios-procuracao', $associado->id) }}" target="_blank">Beneficiários
                                Procuração</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
