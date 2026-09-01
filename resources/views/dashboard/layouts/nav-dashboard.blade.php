<div class="container py-3">

<div class="text-center mb-3">
    <h3 class="fw-bold mb-1">Dashboard</h3>
    <small class="text-muted">
        Bem-vindo, {{ auth()->user()->name }}
    </small>
</div>

@auth
    <div class="row g-2 justify-content-center">

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('dashboard') }}" class="btn btn-success w-100">
                <i class="fa-solid fa-house me-1"></i> Início
            </a>
        </div>

        @hasanyrole('associado')
            <div class="col-12 col-sm-6 col-lg-3">
                <a href="{{ route('associado.informacoes', $associado->id) }}" class="btn btn-primary w-100">
                    <i class="fa-solid fa-user me-1"></i> Meus Dados
                </a>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <a href="{{ route('profile.show') }}" class="btn btn-primary w-100">
                    <i class="fa-solid fa-id-card me-1"></i> Perfil
                </a>
            </div>
        @endhasanyrole

        @hasanyrole('admin|moderador')

            <div class="col-12 col-sm-6 col-lg-3">
                <a href="{{ route('associado.index') }}" class="btn btn-primary w-100">
                    <i class="fa-solid fa-users me-1"></i> Associados
                </a>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <a href="{{ route('profile.show') }}" class="btn btn-primary w-100">
                    <i class="fa-solid fa-user-gear me-1"></i> Perfil
                </a>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <a href="{{ route('planos.index') }}" class="btn btn-primary w-100">
                    <i class="fa-solid fa-clipboard-list me-1"></i> Planos
                </a>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <a href="{{ route('diretoria.index') }}" class="btn btn-primary w-100">
                    <i class="fa-solid fa-building-columns me-1"></i> Diretorias
                </a>
            </div>

            {{-- Financeiro --}}
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle w-100" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-credit-card me-1"></i> Financeiro
                    </button>

                    <ul class="dropdown-menu w-100">
                        <li><a href="{{ route('financeiro.index') }}" class="dropdown-item">Gestão Financeira</a></li>
                        <li><a href="{{ route('importar-pagamentos.index') }}" class="dropdown-item">Importar Pagamentos</a></li>
                        <li><a href="{{ route('pagamentos.index') }}" class="dropdown-item">Pagamentos</a></li>
                    </ul>
                </div>
            </div>

            {{-- Gestão --}}
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle w-100" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-users-gear me-1"></i> Gestão
                    </button>

                    <ul class="dropdown-menu w-100">
                        <li><a href="{{ route('funcionarios.index') }}" class="dropdown-item">Funcionários</a></li>
                        <li><a href="{{ route('prestador-de-servicos-autonomos.index') }}" class="dropdown-item">Prestadores</a></li>
                        <li><a href="{{ route('empresas.index') }}" class="dropdown-item">Empresas</a></li>
                    </ul>
                </div>
            </div>

            {{-- Administração --}}
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle w-100" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-gears me-1"></i> Administração
                    </button>

                    <ul class="dropdown-menu w-100">
                        <li><a href="{{ route('sorteios.index') }}" class="dropdown-item">Sorteios</a></li>
                        <li><a href="{{ route('automacoes.index') }}" class="dropdown-item">Mensagens WhatsApp</a></li>
                        <li><a href="/usuarios" class="dropdown-item">Controle de Acesso</a></li>
                        <li><a href="{{ route('posts.index') }}" class="dropdown-item">Comunicação</a></li>
                        <li><a href="{{ route('banner.create') }}" class="dropdown-item">Banner</a></li>
                        <li><a href="{{ route('configuracoes.index') }}" class="dropdown-item">Configurações</a></li>
                        <li><a href="{{ route('notificacoes.index') }}" class="dropdown-item">Notificações</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="{{ route('como-nos-encontrou.index') }}" class="dropdown-item">Como nos encontrou</a></li>
                    </ul>
                </div>
            </div>

        @endhasanyrole

    </div>
@endauth

</div>
