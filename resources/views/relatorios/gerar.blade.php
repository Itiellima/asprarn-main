<!DOCTYPE html>
<html lang="pt-BR">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
</script>

<head>
    <meta charset="UTF-8">
    <title>ASPRA RN - RELATORIO</title>
    <style>
        /* Simula folha A4 */
        .pagina {
            width: 22cm;
            min-height: 29.7cm;
            padding: 0.5cm 2cm 2cm 2cm;
            /* margem interna */
            margin: 1cm auto;
            /* centralizar na tela */
            border: 1px solid #ffffff;
            background: #fff;
            font-family: Arial, sans-serif;
            font-size: 12pt;
            box-sizing: border-box;
            font-family: 'Times New Roman', Arial, sans-serif;
        }

        .cabecalho {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .cabecalho img {
            position: absolute;
            left: -15px;
            top: 0;
            width: 110px;
            height: 100px;
        }

        .titulo {
            font-size: 13pt;
            font-weight: bold;
            line-height: 1.4;
        }

        .conteudo {
            font-size: 13pt;
            margin-top: 40px;
            text-align: justify;
        }

        .assinatura {
            margin-top: 40px;
            text-align: center;
        }

        .assinatura span {
            display: block;
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 250px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>

    <div class="pagina">
        <div class="cabecalho" >
            <img src="/img/aspra-logo-noname.png" alt="Logo" class="me-2">
            <div class="titulo">
                ASSOCIAÇÃO DOS PRAÇAS DA POLÍCIA MILITAR <br>
                DO ESTADO DO RIO GRANDE DO NORTE <br>
                FUNDADA EM 21 DE ABRIL DE 2003 <br>
                (ASPRA PM/RN)
            </div>
        </div>

        <div class="titulo" style="margin-top: 2cm">
            <p>
                <h4 class="text-center" style="text-decoration: underline; font-weight: bold;">
                    RELATORIO
                </h4>
            </p>
        </div>
        <div class="conteudo">
            @foreach ($associados as $associado)
                <p class="border">
                    {{ $associado->id }} - {{ $associado->nome }} <br>
                    &nbsp; &nbsp; &nbsp; CPF: {{ $associado->cpf }}, RG: {{ $associado->rg }},
                    Nascimento: {{ \Carbon\Carbon::parse($associado->dt_nasc)->format('d/m/Y') }}
                </p>
                
            @endforeach
        </div>



        <div class="container justify-content align-items-center text-center" style="margin-top: 4cm">
            <div class="assinatura" style="text-decoration: underline">
                <strong>
                    Natal/RN, {{ now()->format('d/m/Y') }}<br>
                </strong>
            </div>
            <img style="height: 100px; text-align: center; justify-content: center;" src="/img/assinatura-pr.png"
                alt="">
        </div>

        <div class="text-center border-top border-black" style="margin-top: 2cm">
            <strong>

                SEDE PRÓPRIA: Rua João Pessoa, 267, SL 111, Cidade Alta, Natal/RN, CEP.: 59.025-500
                <br>
                Site: <a href="https://www.asprarn.com">www.asprarn.com</a>, e-mail:asprarn@gmail.com,
                presidencia@asprarn.com
                <br>
                Fone: (84) 3201-0100 / 0800-286-0190 / 9.8823-0100

            </strong>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print(); // Abre a janela de impressão automaticamente
        };
    </script>


</body>

</html>
