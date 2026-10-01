<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Declaração de Associado - ASPRA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <style>
        body {
            background: #e9ecef;
        }

        /* Simula folha A4 */
        .pagina {
            width: 21cm;
            min-height: 29.7cm;
            padding: 2.5cm 2cm 2cm 2cm;
            margin: 1cm auto;
            border: 1px solid #ccc;
            background: #fff;
            font-family: 'Times New Roman', Arial, sans-serif;
            font-size: 12pt;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
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

        .conteudo p {
            margin-top: 1.5rem;
        }

        /* Campos editáveis dentro do texto corrido */
        .campo {
            display: inline-block;
            min-width: 60px;
            border-bottom: 1px dotted #333;
            padding: 0 4px;
            font-weight: bold;
            text-decoration: underline;
            outline: none;
            cursor: text;
        }

        .campo:empty::before {
            content: attr(data-placeholder);
            color: #999;
            font-weight: normal;
            text-decoration: none;
        }

        .campo:focus {
            background: #fff8dc;
        }

        .assinatura {
            margin-top: 2.5rem;
            text-align: center;
        }

        .assinatura img {
            height: 50px;
        }

        .assinatura strong {
            display: block;
        }

        .rodape {
            text-align: center;
            margin-top: auto;
            /* empurra o rodapé para o final da .pagina (flex container) */
            padding-top: 10px;
            border-top: 1px solid #000;
            font-size: 10.5pt;
        }

        .barra-acoes {
            max-width: 21cm;
            margin: 1cm auto 0 auto;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Impressão: some com tudo que não é o papel */
        @media print {
            body {
                background: #fff;
            }

            .barra-acoes {
                display: none !important;
            }

            .pagina {
                border: none;
                margin: 0;
            }

            .campo {
                border-bottom: none;
            }

            .campo:empty::before {
                content: "";
            }
        }
    </style>
</head>

<body>

    <div class="barra-acoes">
        <button type="button" class="btn btn-secondary" onclick="limparCampos()">Limpar campos</button>
        <button type="button" class="btn btn-primary" onclick="window.print()">Imprimir</button>
    </div>

    <div class="pagina" id="documento">
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
            <h4 class="text-center" style="text-decoration: underline; font-weight: bold;">
                DECLARAÇÃO
            </h4>
        </div>

        <div class="conteudo">
            <p style="margin-top: 3rem">
                &nbsp;&nbsp; DECLARO para os devidos fins de direito, que
                <strong><span class="campo" contenteditable="true" data-placeholder="nome do associado"
                        id="nome">{{ $associado->nome ?? '' }}</span></strong>,
                CPF n.º
                <strong><span class="campo" contenteditable="true" data-placeholder="000.000.000-00"
                        id="cpf">{{ $associado->cpf ?? '' }}</span></strong>,
                até esta data, permanece associado regular desta associação, fazendo jus aos benefícios oferecidos
                por esta.
            </p>
        </div>

        <div class="text-center" style="margin-top: 3rem;">
            Natal/RN,
            <span class="campo" contenteditable="true" data-placeholder="dd" id="dia"
                style="min-width: 25px;">{{ now()->format('d') }}</span> de
            <span class="campo" contenteditable="true" data-placeholder="mês" id="mes"
                style="min-width: 80px;">{{ now()->locale('pt_BR')->translatedFormat('F') }}</span> de
            <span class="campo" contenteditable="true" data-placeholder="aaaa" id="ano"
                style="min-width: 45px;">{{ now()->format('Y') }}</span>
        </div>

        <div class="assinatura">
            <img src="/img/assinatura-annay.png" alt="Assinatura">
            <strong>ANNAY KATARINNE LIMA VENTURA</strong>
            <strong>Diretora administrativa ASPRA/RN</strong>
        </div>

        <div class="text-center" style="margin-top: 1.5rem;">
            <strong>OBS: VÁLIDA POR
                <span class="campo" contenteditable="true" data-placeholder="30" id="dias_validade"
                    style="min-width: 30px;">30</span>
                (TRINTA) DIAS.</strong>
        </div>

        <div class="rodape">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script>
        // Limpa todos os campos editáveis, útil para reaproveitar a declaração em branco
        function limparCampos() {
            if (!confirm('Limpar todos os campos preenchidos?')) return;
            document.querySelectorAll('.campo[contenteditable="true"]').forEach(function(campo) {
                campo.textContent = '';
            });
        }
    </script>

</body>

</html>
