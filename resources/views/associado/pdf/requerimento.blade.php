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
                ASSOCIAÇÃO DOS PRAÇAS DA POLÍCIA MILITAR <br>
                DO ESTADO DO RIO GRANDE DO NORTE <br>
                FUNDADA EM 21 DE ABRIL DE 2003 <br>
                (ASPRA PM/RN)
            </div>
        </div>

        <div class="conteudo">

            <p>
                Eu, <strong>{{$associado->nome ?: '__________________'}}</strong>,
                inscrito sob CPF nº: <strong>{{$associado->cpf ?: '__________________'}}</strong>,
                RG:<strong>{{ $associado->rg ?: '__________________'}}</strong>
                Estado Civil: <strong>{{$associado->estado_civil ?: '__________________'}}</strong>
                Graduação: <strong>{{ $associado->graduacao ?: '__________________'}}</strong>
                Nº Praça: <strong>{{ $associado->nmr_praca ?: '__________________' }}</strong>
                Matrícula: <strong>{{ $associado->matricula ?: '__________________' }}</strong>
                OPM: <strong>{{ $associado->opm ?: '__________________' }}</strong>
                Horário de trabalho: <strong>{{ $associado->horario_trabalho ?: '__________________' }}</strong>


                Nascido em: <strong>{{ date('d/m/Y', strtotime($associado->dt_nasc)) ?: '__________________' }}</strong>
                Filho(a) de: <strong>{{ $associado->nome_mae ?: '__________________' }}</strong>,
                e <strong>{{ $associado->nome_pai ?: '__________________' }}</strong>
                Endereço: <strong>{{ $associado->endereco->logradouro ?: '__________________' }}</strong>
                Número: <strong>{{$associado->endereco->nmr ?: '__________________' }}</strong>


                Bairro: <strong>{{ $associado->endereco->bairro ?: '__________________' }}</strong>
                Cidade: <strong>{{ $associado->endereco->cidade ?: '__________________' }}</strong>
                Complemento: <strong>{{ $associado->endereco->complemento ?: '__________________' }}</strong>


                Cursos Civis: <strong>{{$associado->cursos_civis ?: '__________________' }}</strong>
                Grau de Instrução: <strong>{{$associado->grau_instrucao ?: '__________________' }}</strong>


                Telefone Celular: <strong>{{ $associado->contato->tel_celular ?: '__________________' }}</strong>
                Telefone Residencial:
                <strong>{{ $associado->contato->tel_residencial ?? '__________________' }}</strong>
                Telefone Trabalho: <strong>{{ $associado->contato->tel_trabalho ?: '__________________' }}</strong>
                E-mail: <strong>{{ $associado->contato->email ?: '____________________________________' }}</strong>

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
                Conta Nº: Agência: Banco:
                Código para Débito Nº: Contrato de Convênio Nº:
            </p>
            <p>
                Estou ciente que as informações aqui prestadas são de minha inteira responsabilidade, e que, caso queira
                pedir desligamento do quadro social, e tiver em débito para com
                esta entidade terei que ressarcir a mesma de acordo com as diretrizes traçadas pela Diretoria Financeira
                da mesma, sem direito a qualquer ressarcimento dos valores já
                pagos, autorizando, desde já a ASPRA PM/RN, a me representar ativa ou passivamente, em juízo ou fora
                dele, de acordo com o inciso XXI, do Art. 5º da CF, e legislação
                pertinente, em todas as ações, coletivas ou individual, em que tomar parte, que seja de meu interesse ou
                da categoria.
            </p>

            <img src="/img/dependentes.png" alt="dependentes">

        </div>

        <div class="assinatura">
            Natal/RN, ____ de __________________ de 20__ <br>

            <span>Requerente</span>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print(); // Abre a janela de impressão automaticamente
        };
    </script>


</body>

</html>
