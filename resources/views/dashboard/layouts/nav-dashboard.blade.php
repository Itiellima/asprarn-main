<div class="container">


    <h2 class="text-black text-center m-3 alert alert-light">Dashboard: {{ auth()->user()->name }}</h2>

    <nav class="m-3">
        @auth
            <div class="container content-center items-center row justify-content-center">

                {{-- Inicio --}}
                <a href="/dashboard" class="btn btn-success m-1 col-lg-3">🏠 Inicio</a>


                {{-- Associados --}}
                @hasanyrole('associado')
                    <a href="{{ route('associado.informacoes', $associado->id) }}" class="btn btn-primary m-1 col-lg-3">👤 Meus
                        Dados</a>
                    <a href="/profile" class="btn btn-primary m-1 col-lg-3">👮 Perfil</a>
                    {{-- <a href="#" class="btn btn-primary m-1 col-lg-3">📝 Meus Requerimentos</a>
                    <a href="#" class="btn btn-primary m-1 col-lg-3">🎁 Meus Benefícios</a>
                    <a href="#" class="btn btn-primary m-1 col-lg-3">📋 Meus Planos</a>
                    <a href="#" class="btn btn-primary m-1 col-lg-3">🏠 Declarações</a> --}}
                @endhasanyrole

                {{-- Administração --}}
                @hasanyrole('admin|moderador')
                    <a href="{{ route('associado.index') }}" class="btn btn-primary m-1 col-lg-3">👥 Associados</a>
                    <a href="/profile" class="btn btn-primary mx-1 m-1 col-lg-3">👮 Alterar Perfil</a>
                    <a href="{{ route('planos.index') }}" class="btn btn-primary mx-1 m-1 col-lg-3">📋 Planos</a>

                    {{-- Button Administração --}}
                    <div class="dropdown col-lg-3 m-1 p-0">
                        <button class="btn btn-primary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Gestão
                        </button>

                        <ul class="dropdown-menu w-100">
                            <li>
                                <a href="{{ route('funcionarios.index') }}" class="dropdown-item">
                                    👥 Funcionários
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('prestador-de-servicos-autonomos.index') }}" class="dropdown-item">
                                    👥 Prestadores de Serviços
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('empresas.index') }}" class="dropdown-item">
                                    🏢 Empresas
                                </a>
                            </li>
                        </ul>
                    </div>

                    {{-- Button Administração --}}
                    <div class="dropdown col-lg-3 m-1 p-0">
                        <button class="btn btn-primary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Administração
                        </button>

                        <ul class="dropdown-menu w-100">
                            <li>
                                <a href="{{ route('automacoes.index') }}" class="dropdown-item">⚙️ Automacoes</a>
                            </li>
                            <li>
                                <a href="/usuarios" class="dropdown-item">🔐 Controle de Acesso</a>
                            </li>
                            <li>
                                <a href="{{ route('posts.index') }}" class="dropdown-item">​📣 Comunicação</a>
                            </li>
                            <li>
                                <a href="{{ route('banner.create') }}" class="dropdown-item">​📣 Banner</a>
                            </li>
                            <li>
                                <a href="{{ route('configuracoes.index') }}" class="dropdown-item">⚙️ Configurações</a>
                            </li>
                            <li>
                                <a href="{{ route('notificacoes.index') }}" class="dropdown-item">🔔 Notificações</a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">💰 Financeiro*</a>
                            </li>
                        </ul>
                    </div>
                @endhasanyrole
            </div>
        @endauth
    </nav>



</div>
