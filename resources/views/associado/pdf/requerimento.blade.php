<!DOCTYPE html>
<html lang="pt-BR">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
</script>

<head>
    <meta charset="UTF-8">
    <title>Requerimento ASPRA</title>
    <style>
        /* Simula folha A4 */
        .pagina {
            width: 22cm;
            min-height: 29.7cm;
            padding: 0.5cm 2cm 2cm 2cm;
            ;
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
            font-size: 11pt;
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
            width: 400px;
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
                <strong>
                    ASSOCIAÇÃO DOS PRAÇAS DA POLÍCIA MILITAR <br>
                    DO ESTADO DO RIO GRANDE DO NORTE <br>
                    FUNDADA EM 21 DE ABRIL DE 2003 <br>
                    (ASPRA PM/RN)
                </strong>
            </div>
        </div>

        <div class="conteudo">

            <p>
                <h4 class="text-center" style="text-decoration: underline; font-weight: bold;">
                    REQUERIMENTO
                </h4>
            </p>
            <p>
                Sr Presidente,<br>
                Eu, <strong>
                    @if ($associado->nome)
                        <span style="text-decoration: underline;">{{ $associado->nome }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                inscrito sob CPF nº: <strong>
                    @if ($associado->cpf)
                        <span style="text-decoration: underline;">{{ $associado->cpf }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                RG:<strong>
                    @if ($associado->rg)
                        <span style="text-decoration: underline;">{{ $associado->rg }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Estado Civil: <strong>
                    @if ($associado->estado_civil)
                        <span style="text-decoration: underline;">{{ $associado->estado_civil }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Graduação: <strong>
                    @if ($associado->graduacao)
                        <span style="text-decoration: underline;">{{ $associado->graduacao }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Nº Praça: <strong>
                    @if ($associado->nmr_praca)
                        <span style="text-decoration: underline;">{{ $associado->nmr_praca }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Matrícula: <strong>
                    @if ($associado->matricula)
                        <span style="text-decoration: underline;">{{ $associado->matricula }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                OPM: <strong>
                    @if ($associado->opm)
                        <span style="text-decoration: underline:">{{ $associado->opm }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Horário de trabalho: <strong>
                    @if ($associado->horario_trabalho)
                        <span style="text-decoration: underline;">{{ $associado->horario_trabalho }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Nascido em: <strong>
                    @if ($associado->dt_nasc)
                        <span
                            style="text-decoration: underline;">{{ date('d/m/Y', strtotime($associado->dt_nasc)) }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Filho(a) de: <strong>
                    @if ($associado->nome_mae)
                        <span
                            style="text-decoration: underline;">{{ $associado->nome_mae ?: '__________________' }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                e <strong>
                    @if ($associado->nome_pai)
                        <span
                            style="text-decoration: underline;">{{ $associado->nome_pai ?: '__________________' }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Endereço: <strong>
                    @if ($associado->endereco)
                        <span style="text-decoration: underline;">{{ $associado->endereco->logradouro }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Número: <strong>
                    @if ($associado->endereco->nmr)
                        <span style="text-decoration: underline;">{{ $associado->endereco->nmr }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Bairro: <strong>
                    @if ($associado->endereco->bairro)
                        <span style="text-decoration: underline;">{{ $associado->endereco->bairro }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Cidade: <strong>
                    @if ($associado->endereco->cidade)
                        <span style="text-decoration: underline;">{{ $associado->endereco->cidade }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Complemento: <strong>
                    @if ($associado->endereco->complemento)
                        <span style="text-decoration: underline;">{{ $associado->endereco->complemento }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Cursos Civis: <strong>
                    @if ($associado->cursos_civis)
                        <span style="text-decoration: underline;">{{ $associado->cursos_civis }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Grau de Instrução: <strong>
                    @if ($associado->grau_instrucao)
                        <span style="text-decoration: underline;">{{ $associado->grau_instrucao }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Telefone Celular: <strong>
                    @if ($associado->contato->tel_celular)
                        <span style="text-decoration: underline;">{{ $associado->contato->tel_celular }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Telefone Residencial:<strong>
                    @if ($associado->contato->tel_residencial)
                        <span style="text-decoration: underline;">{{ $associado->contato->tel_residencial }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                Telefone Trabalho: <strong>
                    @if ($associado->contato->tel_trabalho)
                        <span style="text-decoration: underline;">{{ $associado->contato->tel_trabalho }}</span>
                    @else
                        __________________
                    @endif
                </strong>
                ,

                E-mail: <strong>
                    @if ($associado->contato->email)
                        <span style="text-decoration: underline;">{{ $associado->contato->email }}</span>
                    @else
                        __________________
                    @endif
                </strong>,

                <br>
                Em caso de acidente avisar à: ___________________________
                Endereço: ________________________________
                Nº:___________ Bairro: _________________________ Cidade: ___________________________________
                <br>

                Telefone Celular: ___________________________
                Telefone Residencial: ___________________________
                Telefone Trabalho: ___________________________,
                <br>
                Venho, mui respeitosamente, REQUER a Vossa Excelência, a minha inscrição no quadro social desta
                entidade, como sócio ____________________, de acordo com a
                letra ________, do art. ________ e Inciso _________ §§ ____ e ____, do art. ________, do Estatuto Social
                desta entidade, autorizando desde já o desconto da
                mensalidade ou despesas em folha de pagamento ou na
                Conta Nº:_________ Agência:_________ Banco:_________
                Código para Débito Nº:_________ Contrato de Convênio Nº:_________
            </p>


            <img src="/img/dependentes.png" alt="dependentes">

        </div>

        <div class="assinatura">
            Natal/RN, ____ de __________________ de 20__ <br>

            <span>Requerente</span>
        </div>


        <div class="text-center mt-5 border-top border-black">
            <strong>
                <a href="https://www.asprarn.com">www.asprarn.com</a>, e-mail: asprarn@gmail.com, contatoasprarn@gmail.com
            </strong>
            <br>
            <strong>
                FONES: (84) 3201-0100 / 9.8823-0100
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
