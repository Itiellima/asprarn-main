<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VERIFICAÇÃO - ASPRA</title>

    {{-- link bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <style>
        .bg-full {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            object-fit: cover;
            /* Faz a imagem preencher sem distorcer */
            z-index: -1;
            /* Joga a imagem para trás do texto */
            opacity: 1;
            /* Opcional: diminui a opacidade para facilitar a leitura do texto */
        }

        .content-overlay {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0">
        <img src="/img/ASPRA-branco.png" class="bg-full" alt="Background">

        <div class="content-overlay">
            <div class="col-md-8">
                @if ($associado->situacoes->contains(fn($situacao) => strtolower($situacao->nome) === 'ativo'))
                    <div class="alert alert-success shadow-lg text-black" role="alert">
                        <h2 class="mb-0">{{ $associado->nome }} é associado e está com vínculo ativo!</h2>
                    </div>
                @else
                    <div class="alert alert-warning shadow-lg text-black" role="alert">
                        <h2 class="mb-0">{{ $associado->nome }} não tem vínculo ativo!</h2>
                    </div>
                @endif
            </div>
        </div>
    </div>

</body>

</html>
