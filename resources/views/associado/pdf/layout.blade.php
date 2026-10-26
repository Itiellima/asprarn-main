{{--
    Layout dos documentos para impressão (Requerimento, SESC, UNP, Declaração, Desfiliação).
    Mesmo padrão visual dos documentos novos: folha A4 na tela, barra com
    "Limpar campos" / "Imprimir" e campos editáveis que somem na impressão.

    Seções:
      titulo    título da aba do navegador
      conteudo  corpo do documento (depois do cabeçalho)
      rodape    opcional; sem ela usa o rodapé padrão com o endereço da sede

    Campos editáveis:
      <span class="campo" contenteditable="true" data-placeholder="...">valor</span>
      + "linha"  → se ficar vazio, sai uma linha no papel para preencher à mão
      + "bloco"  → campo de parágrafo inteiro (ocupa a largura)
--}}
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>@yield('titulo') - ASPRA</title>
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
            padding: 2cm 2cm 1.5cm 2cm;
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
            min-height: 100px;
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

        .titulo-documento {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
        }

        .conteudo {
            font-size: 13pt;
            text-align: justify;
        }

        .conteudo p {
            margin-top: 1.5rem;
        }

        /* Documento com muitos dados (requerimento) */
        .conteudo.compacto {
            font-size: 11pt;
            line-height: 1.7;
        }

        .conteudo.compacto p {
            margin-top: 0.75rem;
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

        .campo.bloco {
            display: block;
            min-height: 4.5em;
            text-decoration: none;
            font-weight: normal;
        }

        .assinatura {
            margin-top: 2.5rem;
            text-align: center;
        }

        .assinatura img {
            height: 100px;
        }

        .linha-assinatura {
            display: block;
            width: 350px;
            margin: 50px auto 0 auto;
            border-top: 1px solid #000;
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
            @page {
                size: A4;
                margin: 0;
            }

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

            /* Campo vazio que deve ser preenchido à mão: vira uma linha no papel */
            .campo.linha:empty {
                border-bottom: 1px solid #000;
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
            <img src="/img/aspra-logo-noname.png" alt="Logo">
            <div class="titulo">
                ASSOCIAÇÃO DOS PRAÇAS DA POLÍCIA MILITAR <br>
                DO ESTADO DO RIO GRANDE DO NORTE <br>
                FUNDADA EM 21 DE ABRIL DE 2003 <br>
                (ASPRA PM/RN)
            </div>
        </div>

        @yield('conteudo')

        <div class="rodape">
            @hasSection('rodape')
                @yield('rodape')
            @else
                <strong>
                    SEDE PRÓPRIA: Rua João Pessoa, 267, SL 111, Cidade Alta, Natal/RN, CEP.: 59.025-500
                    <br>
                    Site: <a href="https://www.asprarn.com">www.asprarn.com</a>, e-mail:asprarn@gmail.com,
                    presidencia@asprarn.com
                    <br>
                    Fone: (84) 3201-0100 / 0800-286-0190 / 9.8823-0100
                </strong>
            @endif
        </div>
    </div>

    <script>
        // Limpa todos os campos editáveis, útil para reaproveitar o documento em branco
        function limparCampos() {
            if (!confirm('Limpar todos os campos preenchidos?')) return;
            document.querySelectorAll('.campo[contenteditable="true"]').forEach(function(campo) {
                campo.textContent = '';
            });
        }
    </script>

</body>

</html>
