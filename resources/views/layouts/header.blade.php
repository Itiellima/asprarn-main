<nav class="navbar navbar-expand-lg navbar-bg" aria-label="Thirteenth navbar example">

    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11"
            aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">

            {{-- logo --}}
            <a href="/" class="navbar-brand col-lg-2 me-0">
                <img src="/img/Aspra.png" alt="Logo" width="120" height="80" class="me-2">
            </a>

            {{-- links --}}
            <ul class="navbar-nav col-lg-8 justify-content-lg-center">
                <li class="nav-item">
                    <a href="/" class="nav-link">
                        <h4>Início</h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('beneficio.index') }}" class="nav-link">
                        <h4>Benefícios</h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('quem.somos') }}" class="nav-link">
                        <h4>Quem somos</h4>
                    </a>
                </li>
                {{-- <li class="nav-item border-bottom">
                    <a href="https://maps.app.goo.gl/wvJbuprZEHSWMRgy8" class="nav-link" target="_blank">
                        <h4>ASPRA</h4>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <h4>Associados</h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contato.index') }}" class="nav-link">
                        <h4>Contato</h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('associado.create') }}" class="nav-link border-bottom">
                        <h4>Quero me associar</h4>
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link">
                            <h4>Minha Página</h4>
                        </a>
                    </li>
                @endauth
            </ul>
            <div class="ms-5">
                @auth
                    {{-- <div class="me-3">Olá, {{ auth()->user()->name }}!</div> --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <label>Olá, {{ auth()->user()->name }}!</label><br>
                        <button id="sair" class="btn btn-primary px-4" type="submit">Sair</button>
                    </form>
                @else
                    {{-- <a class="btn btn-primary mx-2" href="/register">Cadastrar</a> --}}
                    <a class="btn btn-danger" href="/login"><strong>Login</strong></a>
                @endauth

            </div>
        </div>
    </div>
    
</nav>

<!-- Faixa vermelha simples -->
<div style="background:#dc2626;color:#ffffff;padding:10px 16px;text-align:center;font-weight:600;">
    ASPRA PM/RN - Cuidando de quem cuida e protege a nossa sociedade.
</div>
