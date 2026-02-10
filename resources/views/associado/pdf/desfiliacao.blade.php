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
            font-size: 11pt;
            box-sizing: border-box;
            font-family: 'Cambria', 'Times New Roman', Arial, sans-serif;
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
            font-size: 12pt;
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
        
        <div class="" style="margin-top: 2cm">
            <p>
                <strong>
                    AO ILUSTRÍSSIMO SENHOR PRESIDENTE DA ASSOCIAÇÃO DOS PRAÇAS DA POLÍCIA MILITAR DO ESTADO DO RIO
                    GRANDE DO
                    NORTE - ASPRA PM/RN.
                </strong>
            </p>
        </div>
        <div class="titulo" style="margin-top: 1cm">
            <br>
            <p>
            <h5 class="text-center" style="text-decoration: underline; font-weight: bold;">
                REQUERIMENTO DE DESFILIAÇÃO
            </h5>
            </p>
        </div>
        <div class="conteudo">
            <p style="margin-top: 3rem">
                &nbsp;&nbsp; Eu, <strong><span
                        style="text-decoration: underline;">{{ $associado->nome }}</span></strong>, CPF: <strong><span
                        style="text-decoration: underline;">{{ $associado->cpf }}</span></strong>, RG PM: <strong><span
                        style="text-decoration: underline;">{{ $associado->rg }}</span></strong>,
                MATRÍCULA <strong><span style="text-decoration: underline;">{{ $associado->matricula }}</span></strong>,
                vem mui respeitosamente
                perante vossa senhoria, requerer meu desligamento do quadro de associado da ASPRA PM/RN, rubrica 677,
                deacordo com o art. 5º, Inciso XX da Constituição Federal, por não interessar mais permanecer nos
                quadros desta entidade, desistindo ainda de todas as ações coletivas em andamento, em meu favor, tendo
                como substituto processual a ASPRA PM/RN.
            <p style="margin-top: ">
                &nbsp;&nbsp; <strong>Fico ciente ainda, que, caso resolva reingressar na nos quadros de associado da ASPRA
                PM/RN, terei que
                cumprir a carência conforme dispõe o Inciso “III” do parágrafo 3º do art. 50 do Estatuto Social da ASPRA
                PM/RN.</strong>
            </p>
        </div>

        <br>
        <br>
        <br>


        <div class="">
            <p>
                &nbsp;&nbsp;&nbsp;&nbsp;Nestes termos, pede e espera deferimento.
            </p>
            <p class="text-center">
                Natal/RN 	_________ /	_________ /	_________
            </p>
            <p class="text-center">
                Requerente
            </p>
            <p class="text-center">
                _____________________________________________________________
            </p>
        </div>



        <br>
        <br>
        <br>
        <br>
        
        

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
