<!DOCTYPE html>
<html lang="pt-BR">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
</script>

<head>
    <meta charset="UTF-8">
    <title>Declaracao SESC - ASPRA</title>
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
            height: 70px;
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
            <img src="/img/Aspra.png" alt="Logo" width="110" height="70" class="me-2">
            <div class="titulo">
                ASSOCIAÇÃO DOS PRAÇAS DA POLÍCIA MILITAR <br>
                DO ESTADO DO RIO GRANDE DO NORTE <br>
                FUNDADA EM 21 DE ABRIL DE 2003 <br>
                (ASPRA PM/RN)
            </div>
        </div>

        <div class="titulo">
            
        </div>
        <div class="conteudo">
            <p style="margin-top: 3rem">
                &nbsp;&nbsp; A Associação dos Praças da Polícia Militar do Estado do Rio Grande do Norte – ASPRA PMRN,
                inscrita no
                CNPJ sob o nº 05.786.841/0001-63, com sede na Rua João Pessoa, n° 267 – Edifício Cidade do Natal, 1°
                andar, sala 111 – Cidade Alta, Natal/RN, por meio de sua dire-toria, declara para os devidos fins que:
            </p>
            <p style="margin-top: 3rem">
                &nbsp;&nbsp; {{ $associado->nome }}, inscrito no CPF sob o nº {{ $associado->cpf }} e RG nº
                {{ $associado->rg }},
                {{ $associado->org_expedidor }}, tem
                vínculo ativo com esta instituição.
            </p>
            <p style="margin-top: 3rem">
                &nbsp;&nbsp; A presente declaração é emitida a pedido do interessado, para fins de obtenção da
                Credenci-al SESC,
                conforme convênio firmado entre esta Associação e o SESC RN (Nº RN-2025-CON-RCC0033), que assegura ao
                associado o acesso aos benefícios oferecidos pela instituição.
            </p>
        </div>



        <div class="container justify-content align-items-center text-center" style="margin-top: 7cm">
            <div class="assinatura">
                Natal/RN, {{ now()->format('d/m/Y') }}<br>
            </div>
            <img style="height: 100px; text-align: center; justify-content: center;" src="/img/assinatura-pr.png"
                alt="">
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print(); // Abre a janela de impressão automaticamente
        };
    </script>


</body>

</html>
