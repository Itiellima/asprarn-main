<!DOCTYPE html>
<html lang="pt-BR">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
</script>

<head>
    <meta charset="UTF-8">
    <title>CARTEIRA ASSOCIADO - ASPRA</title>
    <style>
        body {
            background: #e5e5e5;
            font-family: Arial, Helvetica, sans-serif;
        }

        .cartao {
            width: 420px;
            height: 240px;
            border-radius: 12px;
            color: white;
            padding: 20px;
            background: linear-gradient(135deg, #0a3a4a, #0c6b8c);
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .topo {
            display: flex;
            align-items: center;
        }

        .foto {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 3px solid white;
            margin-right: 15px;
            object-fit: cover;
        }

        .info {
            max-width: 180px;
        }

        .nome {
            font-size: 18px;
            font-weight: bold;
            line-height: 20px;
            word-break: break-word;
        }

        .tipo {
            font-size: 13px;
            opacity: 0.9;
        }

        .dados {
            margin-top: 45px;
            font-size: 13px;
            line-height: 20px;
        }


        .qrcode {
            position: absolute;
            right: 20px;
            bottom: 20px;
        }

        .qrcode img {
            width: 80px;
        }

        .logo {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .logo img {
            width: 120px;
        }
    </style>
</head>

<body>

    <div class="cartao">

        <div class="logo">
            <img src="{{ asset('img/ASPRA-branco.png') }}" alt="Logo ASPRA">
        </div>

        <div class="topo">
            @if ($associado->pictureProfile?->path)
                <img src="{{ asset('storage/' . $associado->pictureProfile->path) }}" alt="Foto de perfil"
                    class="foto">
            @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="foto" viewBox="0 0 16 16">
                    <path
                        d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5" />
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                </svg>
            @endif

            <div class="info">
                <div class="nome">{{ $associado->nome }} cavalcante da silva</div>
                <div class="tipo">Associado</div>
            </div>
        </div>

        <div class="dados">
            <strong>CPF:</strong> {{ $associado->cpf }}<br>
            <strong>Data de nascimento:</strong> {{ \Carbon\Carbon::parse($associado->dt_nasc)->format('d/m/Y') }}<br>
            <strong>Validade:</strong> {{ \Carbon\Carbon::parse($associado->validade)->addDays(30)->format('d/m/Y') }}<br>
            @if ($associado->graduacao)
                <strong>Graduação:</strong> <label style="text-transform: uppercase"> {{ $associado->graduacao }}</label><br>
            @endif
        </div>

        <div class="qrcode">
            <img src="{{ asset('img/qrcode_www.asprarn.com.br.png') }}">
        </div>

    </div>

</body>

</html>
