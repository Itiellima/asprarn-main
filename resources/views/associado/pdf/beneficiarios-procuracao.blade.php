<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Procuração - ASPRA</title>
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
            padding: 1.5cm 1.5cm 1.5cm 1.5cm;
            margin: 1cm auto;
            border: 1px solid #ccc;
            background: #fff;
            font-family: 'Times New Roman', Arial, sans-serif;
            font-size: 10pt;
            box-sizing: border-box;
        }

        .cabecalho {
            text-align: center;
            margin-bottom: 10px;
        }

        .titulo {
            font-size: 12pt;
            font-weight: bold;
            line-height: 1.2;
        }

        .conteudo {
            font-size: 10pt;
            margin-top: 25px;
            text-align: justify;
            line-height: 1.2;
        }

        .conteudo p {
            margin-top: 1rem;
        }

        /* Campos editáveis dentro do texto corrido */
        .campo {
            display: inline-block;
            min-width: 60px;
            border-bottom: 1px dotted #333;
            padding: 0 4px;
            font-weight: bold;
            text-decoration: none;
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

        /* Bloco de dados cadastrais do outorgante (formulário) */
        .dados {
            margin-top: 1rem;
            border: 1px solid #000;
            padding: 10px 14px;
        }

        .dados .linha {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: none;
            align-items: baseline;
        }

        .dados .linha:last-child {
            margin-bottom: 0;
        }

        .dados .campo-label {
            font-weight: bold;
            margin-right: 6px;
            white-space: nowrap;
        }

        .dados .campo {
            flex: 1;
            min-width: 150px;
        }

        .assinaturas {
            margin-top: 1cm;
        }

        .assinatura-linha {
            margin-top: 3.5rem;
            text-align: center;
        }

        .assinatura-linha span {
            display: block;
            border-top: 1px solid #000;
            width: 320px;
            margin: 0 auto;
            padding-top: 4px;
            font-size: 10pt;
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
                border-bottom: 1px solid #333;
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
            <div class="titulo">
                P R O C U R A Ç Ã O
            </div>
        </div>

        <div class="dados">
            <div class="linha">
                <span class="campo-label">OUTORGANTE:</span>
                <span class="campo" contenteditable="true" data-placeholder="nome completo" id="nome">{{ $associado->nome ?? '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">ENDEREÇO:</span>
                <span class="campo" contenteditable="true" data-placeholder="rua/avenida" id="endereco">{{ $associado->endereco->logradouro ?? '' }}{{ $associado->endereco->bairro ? ', ' . $associado->endereco->bairro : '' }}{{ $associado->endereco->cidade ? ', ' . $associado->endereco->cidade : '' }}{{ $associado->endereco->uf ? ', ' . $associado->endereco->uf : '' }}</span>
                <span class="campo-label">Nº:</span>
                <span class="campo" contenteditable="true" data-placeholder="número" id="numero" style="flex: 0 0 90px;">{{ $associado->endereco->nmr ?? '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">COMPLEMENTO:</span>
                <span class="campo" contenteditable="true" data-placeholder="complemento" id="complemento">{{ $associado->endereco->complemento ?? '' }}</span>
                <span class="campo-label">CEP:</span>
                <span class="campo" contenteditable="true" data-placeholder="00000-000" id="cep" style="flex: 0 0 140px;">{{ $associado->endereco->cep ?? '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">TELEFONE:</span>
                <span class="campo" contenteditable="true" data-placeholder="(84) 90000-0000" id="telefone">{{ $associado->contato->tel_celular ?? '' }}</span>
            </div>
            <div class="linha">
                <span class="campo-label">EMAIL:</span>
                <span class="campo" contenteditable="true" data-placeholder="email@exemplo.com" id="email">{{ $associado->contato->email ?? '' }}</span>    
            </div>
        </div>

        <div class="conteudo">
            <p>
                <strong>nomeio e constituo</strong> como meus procuradores, <strong>WILSON RAMALHO CAVALCANTI NETO –
                    OAB/RN 6.973, ISABELA SALUSTINO DE CARVALHO RAMALHO OAB/RN 8.256 e MARIA LUCINETE DA SILVA DE
                    OLIVEIRA CANUTO – OAB/RN 11.290,</strong> todos brasileiros e advogados, os 4 (quatro) primeiros
                com escritório profissional em <strong>Natal-RN</strong>, na Rua Sachet, 271, 4º andar, Ed. Antonia
                Faustino, Ribeira, CEP 59.012-420, e em <strong>Brasília-DF</strong>, SAUS, Quadra 01, Lote M, Ed.
                Libertas, 9ª andar, sala 905, CEP 70.070-010 e os 2 (dois) últimos com escritório a Rua João Pessoa,
                267, sala 716, Cidade Alta, Natal/RN, CEP.: 59.025-500, aos quais concede os poderes da cláusula
                <em>AD JUDICIA ET EXTRA</em>, para o foro em geral, podendo atuar em todas e quaisquer instâncias
                judiciais ou extrajudiciais (administrativas), seja autor ou reclamante, interessado ou requerido,
                podendo reclamar, vender, receber, dar quitação, dar quitação, firmar compromissos, prestar
                declarações, podendo agir em conjunto ou separado, bem como substabelecer a presente, praticando
                todos os atos necessários, para o bom e fiel desempenho.
            </p>
            <p>
                <strong>PODERES ESPECÍFICOS:</strong> A presente procuração outorga aos Advogados acima descritos,
                os poderes para receber citação, confessar, reconhecer a procedência do pedido, transigir, desistir,
                renunciar ao direito sobre o qual se funda a ação, receber, dar quitação, firmar compromisso, pedir à
                justiça gratuita e assinar declaração de hipossuficiência econômica. (Em conformidade com a norma do
                art. 105 do CPC).
            </p>

            <div class="titulo text-center" style="margin-top: 1.5rem;">
                CONTRATO DE HONORÁRIOS
            </div>

            <p>
                Concomitantemente com os poderes acima outorgados, o outorgante acede em pagar aos advogados
                contratados, honorários contratuais no percentual de 30% da condenação, ficando, desde já,
                autorizada a retenção na fonte pagadora.
            </p>
            <p>
                Bem como a pagar em relação à verba vincenda, o equivalente a 30% da parcela majorada dos
                vencimentos/proventos do militar estadual, os honorários incidirão, exclusivamente, sobre essa
                parcela majorada e a cobrança de honorários vigorará, apenas, sobre os primeiros 24 (vinte e quatro)
                meses de percepção de vencimentos majorados, pelo aderente. Pelo presente instrumento, fica
                devidamente autorizado que os referidos honorários advocatícios vincendos, poderão ser retidos nos
                respectivos autos do processo judicial, conforme expresso permissivo legal extraído do Estatuto da
                OAB, ou poderão ser pagos, conforme Estatuto da ASPRA PM/RN, CNPJ Nº 05.786.741/0001-63, diretamente
                à Associação, através de retenções em folha de pagamento ou, ainda, através de débito mensal em
                conta corrente, cuja autorização fica expressamente conferida, respeitando-se, por conseguinte, os
                limites estabelecidos pelo presente instrumento, no caso de impossibilidade de retenção na fonte.
            </p>
            <p>
                Os honorários contratuais, aqui pactuados, serão divididos entre os advogados na seguinte proporção:
                15% para o advogado WILSON RAMALHO CAVALCANTI NETO – OAB/RN 6.973, e 15% para a advogada MARIA
                LUCINETE DA SILVA DE OLIVEIR CANUTO – OAB/RN 11290, autorizando desde já a expedição dos alvarás em
                separado no nome de cada advogado beneficiado.
            </p>
            <p>
                Por fim, fica ainda a ASSOCIAÇÃO DOS PRAÇAS DA POLÍCIA MILITAR DO ESTADO DO RIO GRANDE DO NORTE –
                ASPRA PM/RN, CNPJ Nº 05.786.741/0001-63, autorizada a efetuar a cobrança dos honorários contratuais
                vincendos, da forma permitida em seus Estatutos, bem como, através de desconto em folha de pagamento
                ou através de débito na conta corrente indicada pelo Outorgante, caso não seja possível a retenção
                dos referidos honorários, na fonte.
            </p>
        </div>

        <div class="text-center" style="margin-top: 2.5rem;">
            <span class="campo" contenteditable="true" data-placeholder="cidade" id="cidade" style="min-width: 160px;">{{ $associado->cidade ?? 'Natal/RN' }}</span>,
            <span class="campo" contenteditable="true" data-placeholder="dd" id="dia" style="min-width: 25px;">{{ now()->format('d') }}</span> /
            <span class="campo" contenteditable="true" data-placeholder="mm" id="mes" style="min-width: 25px;">{{ now()->format('m') }}</span> /
            <span class="campo" contenteditable="true" data-placeholder="aaaa" id="ano" style="min-width: 45px;">{{ now()->format('Y') }}</span>
        </div>

        <div class="assinaturas">
            <div class="assinatura-linha">
                <span>OUTORGANTE</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script>
        // Limpa todos os campos editáveis, útil para reaproveitar a procuração em branco
        function limparCampos() {
            if (!confirm('Limpar todos os campos preenchidos?')) return;
            document.querySelectorAll('.campo[contenteditable="true"]').forEach(function (campo) {
                campo.textContent = '';
            });
        }
    </script>

</body>

</html>
