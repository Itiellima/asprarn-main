<div class="container">
    <aside class="w-64 min-h-screen bg-gray-800 p-4">

        <h2 class="text-black text-center m-3 alert alert-light">Dashboard: {{ auth()->user()->name }}</h2>

        <nav class="m-3">
            @auth
                <div class="dropdown">

                    <a href="/dashboard" class="btn btn-success mx-1">🏠 Inicio</a>
                    @hasanyrole('associado')
                    <a href="#" class="btn btn-primary mx-1">🏠 Meus beneficios</a>
                    <a href="#" class="btn btn-primary mx-1">🏠 Declarações</a>
                    @endhasanyrole


                    @hasanyrole('admin|moderador')
                        <a href="{{ route('associado.index') }}" class="btn btn-primary">👥 Gestão de Associados</a>
                        <a href="/profile" class="btn btn-primary mx-1">👮 Alterar Perfil</a>

                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Administração Menu
                        </button>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="#" class="dropdown-item">📊 Visão Geral (Dashboard)*</a>
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
