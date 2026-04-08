<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="/img/Escudo-pm.png" type="image/x-icon">

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
    <script src="https://cdn.tiny.cloud/1/upncklldk8fd5828pgscoflojmf8t2bd82ejr0orc4r417us/tinymce/8/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>
    <script>
        tinymce.init({
            selector: '#editor'
        });
    </script>

    <style>
        body {
            font-family: Montserrat;
            /* Lista de fontes */
        }
    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    {{-- owl css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    {{-- AOS link --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    {{-- manifest pwa --}}
    <link rel="manifest" href="/manifest.json">

</head>

<body>
    {{-- Header --}}
    <header>
        @include('layouts.header')
    </header>

    {{-- Alertas --}}
    <div class="container px-3 py-3">
        @if (session('msg'))
            <div class="container alert alert-success">
                {{ session('msg') }}
            </div>
        @endif
        @if (session('error'))
            <div class="container alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="container alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="container alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>


    {{-- Conteúdo principal --}}
    <div>
        <main class="">
            @yield('content')
        </main>
    </div>

    {{-- Footer --}}
    <footer class="text-center footer-bg">
        @include('layouts.footer')
    </footer>

    <!-- Botão Flutuante WhatsApp HTML -->
    <a href="https://wa.me/message/ABFVUULB5HXIK1"
        style="position:fixed;width:60px;height:60px;bottom:40px;right:40px;background-color:#25d366;color:#FFF;border-radius:50px;text-align:center;font-size:30px;box-shadow: 1px 1px 2px #888;z-index:10000;display:flex;justify-content:center;align-items:center;"
        target="_blank">
        <img src="/img/whatsapp.png" style="width: 35px; height: 35px;" alt="WhatsApp" />
    </a>




    {{-- Impede varios clicks --}}
    <script src="{{ asset('js/form-double-click.js') }}"></script>

    {{-- AOS script --}}
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>


    {{-- owl js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    @stack('scripts')

    <script>
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register("/service-worker.js");
        }
    </script>
</body>

</html>
