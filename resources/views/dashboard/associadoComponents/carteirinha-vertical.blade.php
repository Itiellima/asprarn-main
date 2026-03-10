<!DOCTYPE html>
<html lang="pt-BR">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
</script>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARTEIRA ASSOCIADO - ASPRA</title>
    <style>
        .cartao {
            width: 92vw;
            /* ocupa quase toda a largura da tela */
            max-width: 380px;
            /* limite no desktop */
            aspect-ratio: 260 / 420;
            /* mantém proporção do cartão */

            border-radius: 12px;
            color: white;
            padding: 15px;

            background: linear-gradient(135deg, #0a3a4a, #0c6b8c);
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            width: 130px;
        }

        .foto {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .nome {
            font-size: 20px;
            font-weight: bold;
            line-height: 20px;
            margin-bottom: 5px;
        }

        .tipo {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .dados {
            font-size: 16px;
            line-height: 22px;
            text-align: left;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .qrcode {
            margin-top: 15px;
        }

        .qrcode img {
            width: 140px;
        }

        body {
            margin: 0;
            background: #e5e5e5;

            display: flex;
            justify-content: center;
            align-items: center;

            min-height: 100vh;
        }

        @media (max-width:480px) {

            .foto {
                width: 80px;
                height: 80px;
            }

            .nome {
                font-size: 20px;
            }

            .dados {
                font-size: 16px;
            }

            .logo img {
                width: 120px;
            }

            .qrcode img {
                width: 120px;
            }

        }
    </style>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

</head>

<body>

    <div class="cartao" id="cartao">

        <div class="logo">
            <img src="{{ asset('img/ASPRA-branco.png') }}">
        </div>

        @if ($associado->pictureProfile?->path)
            <img src="{{ asset('storage/' . $associado->pictureProfile->path) }}" class="foto">
        @else
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="foto" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
            </svg>
        @endif

        <div class="nome">
            {{ $associado->nome }}
        </div>

        <div class="tipo">
            Associado
        </div>

        <div class="dados">
            <strong>CPF:</strong> {{ $associado->cpf }} <br>

            <strong>Nascimento:</strong>
            {{ \Carbon\Carbon::parse($associado->dt_nasc)->format('d/m/Y') }} <br>

            <strong>Validade:</strong>
            {{ \Carbon\Carbon::parse($associado->validade)->addDays(30)->format('d/m/Y') }} <br>

            @if ($associado->graduacao)
                <strong>Graduação:</strong>
                <span style="text-transform:uppercase">
                    {{ $associado->graduacao }}
                </span>
            @endif
        </div>

        <div class="qrcode">
            <img src="{{ asset('img/qrcode_www.asprarn.com.br.png') }}">
        </div>

    </div>

</body>

</html>
