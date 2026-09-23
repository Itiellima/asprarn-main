<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Termo de Adesão ACP - ASPRA</title>
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
            padding: 1.5cm 2cm 2cm 2cm;
            margin: 1cm auto;
            border: 1px solid #ccc;
            background: #fff;
            font-family: 'Times New Roman', Arial, sans-serif;
            font-size: 12pt;
            box-sizing: border-box;
        }

        .cabecalho {
            text-align: center;
            margin-bottom: 20px;
        }

        .titulo {
            font-size: 13pt;
            font-weight: bold;
            line-height: 1.4;
        }

        .conteudo {
            font-size: 12.5pt;
            margin-top: 25px;
            text-align: justify;
            line-height: 1.5;
        }

        .conteudo p {
            margin-top: 1.2rem;
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

        /* Blocos de dados cadastrais (formulário) */
        .dados {
            margin-top: 2rem;
        }

        .dados .linha {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
            align-items: baseline;
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

        .estado-civil-opcao {
            cursor: pointer;
            margin-right: 18px;
            white-space: nowrap;
            user-select: none;
        }

        .estado-civil-opcao .caixa {
            display: inline-block;
            width: 16px;
            text-align: center;
            font-weight: bold;
        }

        .assinaturas {
            margin-top: 3cm;
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
            font-size: 11pt;
        }

        .testemunhas {
            margin-top: 3rem;
            display: flex;
            justify-content: space-between;
            gap: 40px;
        }

        .testemunha {
            flex: 1;
        }

        .testemunha .linha-assinatura {
            border-top: 1px solid #000;
            margin-top: 2.5rem;
            margin-bottom: 4px;
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
                width: auto;
                min-height: auto;
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

            </div>
        </div>

        <div class="titulo text-center" style="margin-top: 1.5cm; text-decoration: underline;">
            TERMO DE ADESÃO
        </div>

        <div class="conteudo">
            <p>
                Pelo presente TERMO DE ADESÃO, o militar ou pensionista de militar, do Estado do Rio Grande do Norte
                (policial militar ou bombeiro militar), abaixo qualificado, aqui aderente e presente na assembleia
                geral extraordinária realizada pela ASSOCIAÇÃO DOS PRAÇAS DA POLÍCIA MILITAR DO ESTADO DO RIO GRANDE
                DO NORTE – ASPRA/RN, aos 27 de setembro de 2024, na Sede do Clube dos Diretores Lojistas, localizado
                a Rua Ceará-mirim, 322, Tirol, 2º andar (salão de eventos), Natal-RN, conclave que se constituiu
                visando a propositura de medida judicial em face do Estado do RN, com o objetivo de garantir aos
                militares estaduais o direito a promoções funcionais sucessivas e retroatividade destas,
                proporcionalmente ao respectivo tempo de serviço, bem como, o direito ao pagamento de diferenças de
                vencimentos/proventos retroativos aos últimos anos, <strong>AUTORIZA</strong>, na melhor forma de
                direito, que a ASPRA PM/RN, promova, através de seus advogados, a medida judicial devida, visando
                atingir os objetivos retro-identificados, bem como, <strong>AUTORIZA</strong> que lhe seja feita a
                cobrança de honorários advocatícios profissionais, à razão de 30% (trinta por cento), sobre o
                benefício econômico financeiro auferido pelo signatário, correspondente as diferenças que lhes são
                devidas, bem como, em relação à majoração de vencimentos/proventos a que fará <em>jus</em>, após a
                efetivação de sua promoção. Assim, o benefício econômico a ser auferido pelo aderente se divide em
                dois: verbas vencidas e verbas vincendas.
            </p>
            <p>
                Para fins de base de cálculo dos honorários advocatícios, fica esclarecido que, em relação à verba
                vencida, os honorários incidirão sobre as diferenças a serem percebidas pelo aderente, por força do
                processo judicial, a ser patrocinado em seu favor. Já em relação à verba vincenda, equivalente à
                parcela majorada dos vencimentos/proventos do militar estadual, os honorários incidirão,
                exclusivamente, sobre essa parcela majorada e a cobrança de honorários vigorará, apenas, sobre os
                primeiros 24 (vinte e quatro) meses de percepção de vencimentos majorados, pelo aderente, sendo 50%
                (cinquenta por cento) em nome de Wilson Ramalho Cavalcanti Neto, OAB/RN 69.73 e 50% (cinquenta por
                cento) em nome de Maria Lucinete da Silva de Oliveira Canuto, OAB/RN 11.290, do total de 30% (trinta
                por cento), sendo 15% (quinze por cento) em favor da Advogada Maria Lucinete da Silva de Oliveira
                Canuto, OAB/RN 11.290 e 15% (quinze por cento) em favor do Advogado Wilson Ramalho Cavalcanti Neto,
                OAB/RN 69.73. Pelo presente instrumento, fica devidamente autorizado que os referidos honorários
                advocatícios vincendos, poderão ser retidos nos respectivos autos do processo judicial, conforme
                expresso permissivo legal extraído do Estatuto da OAB, ou poderão ser pagos, conforme Estatuto da
                ASPRA PM/RN - ASSOCIAÇÃO DOS PRAÇAS DA POLÍCIA MILITAR DO ESTADO DO RIO GRANDE DO NORTE – ASPRA
                PM/RN, CNPJ Nº 05.786.741/0001-63, diretamente à Associação, através de retenções em folha de
                pagamento ou, ainda, através de débito mensal em conta corrente, cuja autorização fica expressamente
                conferida, respeitando-se, por conseguinte, os limites estabelecidos pelo presente instrumento, no
                caso de impossibilidade de retenção na fonte.
            </p>
            <p>
                Na oportunidade, fica esclarecido, por fim, que os honorários advocatícios aqui ajustados são
                distintos dos eventuais honorários sucumbenciais a que o Estado do RN venha a ser eventualmente
                condenado a pagar, consoante regra da Lei n.º 5.584/70, ficando igualmente rateados entre os
                causídicos, conforme disposto acima.
            </p>
            <p>
                Fica o aderente obrigado a apresentar seus respectivos documentos pessoais, inclusive, dados
                bancários, bem como, firmar procuração em favor dos advogados da ASPRA PM/RN, para fins do
                ajuizamento da ação específica.
            </p>
            <p>
                O presente termo de adesão passa a ser assinado pelo aderente e pela ASPRA PM/RN, que a tudo leram e
                concordaram, na presença de duas testemunhas, impondo ao presente instrumento força executiva, na
                forma do art. 585, II, CPC.
            </p>
        </div>

        <div class="dados">
            <div class="linha">
                <span class="campo-label">1) Militar/Pensionista aderente (nome):</span>
                <span class="campo" contenteditable="true" data-placeholder="nome completo"
                    id="nome">{{ $associado->nome ?? '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">2) Estado civil:</span>
                <span class="estado-civil-opcao" onclick="marcarEstadoCivil(this)" data-valor="casado">
                    <span class="caixa"></span> casado
                </span>
                <span class="estado-civil-opcao" onclick="marcarEstadoCivil(this)" data-valor="solteiro">
                    <span class="caixa"></span> solteiro
                </span>
                <span class="estado-civil-opcao" onclick="marcarEstadoCivil(this)" data-valor="divorciado">
                    <span class="caixa"></span> divorciado
                </span>
                <span class="estado-civil-opcao" onclick="marcarEstadoCivil(this)" data-valor="viuvo">
                    <span class="caixa"></span> viúvo
                </span>
            </div>

            <div class="linha">
                <span class="campo-label">3) Identidade profissional:</span>
                <span class="campo" contenteditable="true" data-placeholder="nº da identidade"
                    id="identidade">{{ $associado->rg ?? '' }}{{ $associado->org_expedidor ? ' - ' . $associado->org_expedidor : '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">4) CPF:</span>
                <span class="campo" contenteditable="true" data-placeholder="000.000.000-00"
                    id="cpf">{{ $associado->cpf ?? '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">5) Endereço:</span>
                <span class="campo" contenteditable="true" data-placeholder="rua, número, complemento"
                    id="endereco">{{ $associado->endereco->logradouro ?? '' }}{{ $associado->endereco->nmr ? ', ' . $associado->endereco->nmr : '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">5.1) Bairro:</span>
                <span class="campo" contenteditable="true" data-placeholder="bairro"
                    id="bairro">{{ $associado->endereco->bairro ?? '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">5.2) CEP:</span>
                <span class="campo" contenteditable="true" data-placeholder="00000-000"
                    id="cep">{{ $associado->endereco->cep ?? '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">5.3) Cidade/UF:</span>
                <span class="campo" contenteditable="true" data-placeholder="cidade"
                    id="cidade">{{ $associado->endereco->cidade ?? '' }}{{ $associado->endereco->uf ? ', ' . $associado->endereco->uf : '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">6) Email:</span>
                <span class="campo" contenteditable="true" data-placeholder="email@exemplo.com"
                    id="email">{{ $associado->contato->email ?? '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">7) Telefone:</span>
                <span class="campo" contenteditable="true" data-placeholder="(84) 90000-0000"
                    id="telefone">{{ $associado->contato->tel_celular ?? '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">8) Cargo:</span>
                <span class="campo" contenteditable="true" data-placeholder="cargo/posto/graduação"
                    id="cargo">{{ $associado->cargo ?? '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">9) Data de admissão:</span>
                <span class="campo" contenteditable="true" data-placeholder="dd/mm/aaaa"
                    id="data_admissao">{{ $associado->dt_inclusao ? $associado->dt_inclusao->format('d/m/Y') : '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">10) Conta corrente:</span>
                <span class="campo" contenteditable="true" data-placeholder="nº da conta"
                    id="conta_corrente">{{ $associado->dados_bancarios->conta_corrente ?? '' }}</span>
            </div>

            <div class="linha">
                <span class="campo-label">11) Agência/Banco:</span>
                <span class="campo" contenteditable="true" data-placeholder="agência / banco"
                    id="agencia_banco">{{ $associado->dados_bancarios->agencia_banco ?? '' }}</span>
            </div>
        </div>

        <div class="text-center" style="margin-top: 2.5rem;">
            Natal/RN,
            <span class="campo" contenteditable="true" data-placeholder="dd" id="dia"
                style="min-width: 25px;">{{ now()->format('d') }}</span> /
            <span class="campo" contenteditable="true" data-placeholder="mm" id="mes"
                style="min-width: 25px;">{{ now()->format('m') }}</span> /
            <span class="campo" contenteditable="true" data-placeholder="aaaa" id="ano"
                style="min-width: 45px;">{{ now()->format('Y') }}</span>
        </div>

        <div class="assinaturas">
            <div class="assinatura-linha">
                <span>MILITAR/PENSIONISTA ADERENTE</span>

                <span style="border-top: none; border-bottom: none;" class="campo" contenteditable="true"
                    data-placeholder="000.000.000-00" id="cpf_assinatura">{{ $associado->cpf ?? '' }}</span>
                <span>CPF</span>

                
            </div>

            <div class="testemunhas">
                <div class="testemunha">
                    <div class="linha-assinatura"></div>
                    <div>TESTEMUNHA 1</div>
                    <div>NOME: <span class="campo" contenteditable="true" data-placeholder="nome"
                            id="test1_nome"></span></div>
                    <div>CPF: <span class="campo" contenteditable="true" data-placeholder="cpf"
                            id="test1_cpf"></span></div>
                </div>
                <div class="testemunha">
                    <div class="linha-assinatura"></div>
                    <div>TESTEMUNHA 2</div>
                    <div>NOME: <span class="campo" contenteditable="true" data-placeholder="nome"
                            id="test2_nome"></span></div>
                    <div>CPF: <span class="campo" contenteditable="true" data-placeholder="cpf"
                            id="test2_cpf"></span></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script>
        // Marca a opção de estado civil clicada e desmarca as demais
        function marcarEstadoCivil(elemento) {
            document.querySelectorAll('.estado-civil-opcao .caixa').forEach(function(caixa) {
                caixa.textContent = '';
            });
            elemento.querySelector('.caixa').textContent = 'X';
        }

        // Limpa todos os campos editáveis, útil para reaproveitar o termo em branco
        function limparCampos() {
            if (!confirm('Limpar todos os campos preenchidos?')) return;
            document.querySelectorAll('.campo[contenteditable="true"]').forEach(function(campo) {
                campo.textContent = '';
            });
            document.querySelectorAll('.estado-civil-opcao .caixa').forEach(function(caixa) {
                caixa.textContent = '';
            });
        }
    </script>

</body>

</html>
