<!DOCTYPE html>
<html lang="pt-BR">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
</script>

<head>
    <meta charset="UTF-8">
    <title>Declaracao UNP - ASPRA</title>
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
        <div class="cabecalho">
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
                DECLARAÇÃO
            </h4>
            </p>
        </div>
        <div class="conteudo">
            <p style="margin-top: 3rem">
                &nbsp;&nbsp; <strong>A Associação dos Praças da Polícia Militar do Estado do Rio Grande do Norte – ASPRA
                    PMRN,</strong>
                inscrita no
                CNPJ sob o nº 05.786.841/0001-63, com sede na Rua João Pessoa, n° 267 – Edifício Cidade do Natal, 1°
                andar, sala 111 – Cidade Alta, Natal/RN, por meio de sua diretoria, declara para os devidos fins que:
            </p>
            <p style="margin-top: 3rem">
                &nbsp;&nbsp; <strong><span style="text-decoration: underline;">{{ $associado->nome }}</span></strong>,
                inscrito no CPF sob o nº <strong><span
                        style="text-decoration: underline;">{{ $associado->cpf }}</span></strong> e RG nº
                <strong><span style="text-decoration: underline;">{{ $associado->rg }}</span></strong>,
                <strong><span style="text-decoration: underline;">{{ $associado->org_expedidor }}</span></strong>, tem
                vínculo ativo com esta instituição.
            </p>
            <p style="margin-top: 3rem">
                &nbsp;&nbsp; A presente declaração é emitida a pedido do interessado, para fins de
                <strong>matricula na Universidade Potiguar do Rio Grande do Norte (UNP),</strong>
            </p>
        </div>


        <br><br>
        <br>
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
