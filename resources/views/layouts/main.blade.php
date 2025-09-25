<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    {{-- link bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>


    {{-- link font Roboto --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="/css/style.css">

    <!-- CKEditor com sua chave -->
   <script src="https://cdn.tiny.cloud/1/upncklldk8fd5828pgscoflojmf8t2bd82ejr0orc4r417us/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <script>
      tinymce.init({
        selector: '#editor'
      });
    </script>


    <style>
        body {
            font-family: Arial;
            /* Lista de fontes */
        }
    </style>

</head>

<body class="">
    {{-- Header --}}
    <header class="">
        <nav class="row align-items-center border-bottom fixed-top bg-light">

            <div class="col-md-3 text-center text-start">
                <a href="/" class="d-inline-flex align-items-center text-decoration-none">
                    <img src="/img/Aspra.png" alt="Logo" width="110" height="70" class="me-2">
                    <span class="fs-5 fw-bold"></span>
                </a>
            </div>


            <div class="col-md-6 text-align-center">
                <ul class="nav mb-2 justify-content-center mb-md-0">
                    <li><a href="/" class="nav-link px-2 link-secondary">Inicio</a></li>
                    <li><a href="#" class="nav-link px-2">Votação</a></li>
                    <li><a href="{{ route('beneficio.index') }}" class="nav-link px-2">Benefícios</a></li>
                    <li><a href="#" class="nav-link px-2">ASPRA</a></li>
                    <li><a href="#" class="nav-link px-2">Sobre</a></li>
                    <li><a href="/associado/create" class="nav-link px-2 border-bottom">Quero me associar</a></li>

                    {{-- Verifica se o usuário está autenticado e se é admin --}}
                    @auth
                        <!-- Usuário está logado -->

                        <li><a href="/dashboard" class="nav-link px-2">Minha Pagina</a></li>
                    @else
                        <!-- Usuário não está logado -->
                    @endauth

                </ul>

            </div>


            <div class="col-md-3 text-center align-items-center d-flex justify-content-center">
                @auth
                    <!-- Exibe o nome do usuário logado -->
                    <div class="me-3">
                        Olá, {{ auth()->user()->name }}!
                    </div>

                    <!-- Usuário está logado -->
                    <form method="POST" action="{{ route('logout') }}" class="ms-3">
                        @csrf
                        <button class="btn btn-primary" type="submit">Sair</button>
                    </form>
                @else
                    <!-- Usuário não está logado -->
                    <a class="btn btn-primary mx-2" href="/register">Cadastrar</a>
                    <a class="btn btn-primary mx-2" href="/login">Login</a>
                @endauth

            </div>
        </nav>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const navbar = document.querySelector('nav.fixed-top');
                if (navbar) {
                    const navbarHeight = navbar.offsetHeight;
                    document.body.style.paddingTop = navbarHeight + 'px';
                }
            });
        </script>
    </header>

    {{-- Alertas --}}
    <div class="container m-3">
        @if (session('msg'))
            <div class="alert alert-success">
                {{ session('msg') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>


    <div>
        <main class="">
            @yield('content')
        </main>
    </div>




    <footer class="text-center bg-light border-top py-2 mt-auto">
        <div class="container">
            <div class="row align-items-center">

                <!-- Coluna 1: Logo -->
                <div class="col-md-4 mb-3 mb-md-0 text-md-start text-center">
                    <a href="/" class="d-inline-flex align-items-center text-decoration-none">
                        <img src="/img/Aspra.png" alt="Logo" width="100" height="65" class="me-2">
                    </a>
                    <p class="mb-0">&copy; {{ date('Y') }} ASPRA RN</p>
                </div>

                <!-- Coluna 2: Endereço -->
                <div class="col-md-4 mb-3 mb-md-0 text-center">
                    <p class="mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-envelope-at me-1" viewBox="0 0 16 16">
                            <path
                                d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z" />
                            <path
                                d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z" />
                        </svg>
                        Rua João Pessoa, 267, sala 111, edifício Cidade do Natal, Cidade Alta, Natal/RN
                    </p>
                </div>

                <!-- Coluna 3: Contatos -->
                <div class="col-md-4 text-md-end text-center">
                    <p class="mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-phone me-1" viewBox="0 0 16 16">
                            <path
                                d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                            <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                        </svg>
                        Tel: (84) 3201-0100
                    </p>
                    <p class="mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-building me-1" viewBox="0 0 16 16">
                            <path
                                d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                            <path
                                d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z" />
                        </svg>
                        Email: contatoasprarn@gmail.com
                    </p>
                </div>

            </div>
        </div>
    </footer>

    <script src="{{ asset('js/form-double-click.js') }}"></script>
    <script src="{{ asset('js/form-texto.js') }}"></script>

</body>

</html>
