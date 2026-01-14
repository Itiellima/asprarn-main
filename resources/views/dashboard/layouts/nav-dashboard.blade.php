<div class="container">


    <h2 class="text-black text-center m-3 alert alert-light">Dashboard: {{ auth()->user()->name }}</h2>

    <nav class="m-3">
        @auth
            <div class="container content-center items-center row justify-content-center">

                {{-- Inicio --}}
                <a href="/dashboard" class="btn btn-success m-1 col-lg-3">🏠 Inicio</a>


                {{-- Associados --}}
                @hasanyrole('associado')
                    <a href="#" class="btn btn-primary m-1 col-lg-3">👤 Minha Área</a>
                    <a href="#" class="btn btn-primary m-1 col-lg-3">📝 Meus Requerimentos</a>
                    <a href="#" class="btn btn-primary m-1 col-lg-3">🎁 Meus Benefícios</a>
                    <a href="#" class="btn btn-primary m-1 col-lg-3">📋 Meus Planos</a>
                    <a href="#" class="btn btn-primary m-1 col-lg-3">🏠 Declarações</a>
                @endhasanyrole

                {{-- Administração --}}
                @hasanyrole('admin|moderador')
                    <a href="{{ route('associado.index') }}" class="btn btn-primary m-1 col-lg-3">👥 Gestão de Associados</a>
                    <a href="/profile" class="btn btn-primary mx-1 m-1 col-lg-3">👮 Alterar Perfil</a>
                    <a href="{{ route('planos.index') }}" class="btn btn-primary mx-1 m-1 col-lg-3">📋 Planos</a>

                    <button class="btn btn-primary dropdown-toggle m-1 col-lg-3" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Administração Menu
                    </button>

                    <ul class="dropdown-menu col-lg-3">
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
                @endhasanyrole
            </div>
        @endauth
    </nav>



</div>
