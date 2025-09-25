<div class="container">
    <aside class="w-64 min-h-screen bg-gray-800 p-4">

        <h2 class="text-xl font-bold mb-6">Dashboard: {{ auth()->user()->name }}</h2>

        <nav>
            @auth
                <div class="dropdown">

                    <a href="/dashboard" class="btn btn-secondary mx-1">🏠 Home</a>



                    @hasanyrole('admin|moderador')
                        <a href="/profile" class="btn btn-secondary mx-1">👮 Alterar Perfil</a>

                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Administração Menu
                        </button>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="#" class="dropdown-item">📊 Visão Geral (Dashboard)*</a>
                            </li>
                            <li>
                                <a href="{{ route('associado.index') }}" class="dropdown-item">👥 Gestão de Associados</a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">💰 Financeiro*</a>
                            </li>
                            <li>
                                <a href="/usuarios" class="dropdown-item">🔐 Controle de Acesso</a>
                            </li>
                            <li>
                                <a href="{{ route('posts.index') }}" class="dropdown-item">​📣 Comunicação</a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">⚙️ Configurações*</a>
                            </li>
                        </ul>
                    @endhasanyrole
                </div>
            @endauth
        </nav>


    </aside>


</div>
