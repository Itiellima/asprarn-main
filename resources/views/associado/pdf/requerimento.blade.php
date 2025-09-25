<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Requerimento ASPRA</title>
    <style>
        /* Simula folha A4 */
        .pagina {
            width: 22cm;
            min-height: 29.7cm;
            padding: 0.5cm 2cm 2cm 2cm;;
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
            margin-top: 100px;
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

        <div class="conteudo">

            <p>
                Eu, <strong>{{ str_pad($associado->nome ?? '', 40, '_') }}</strong>,
                inscrito sob CPF nº: <strong>{{ str_pad($associado->cpf ?? '', 20, '_') }}</strong>,
                <br>

                RG:<strong>{{ str_pad($associado->rg ?? '', 10, '_') }}</strong>
                Estado Civil: <strong>{{ str_pad($associado->estado_civil ?? '', 15, '_') }}</strong>
                Graduação: <strong>{{ str_pad($associado->graduacao ?? '', 15, '_') }}</strong>
                Nº Praça: <strong>{{ str_pad($associado->nmr_praca ?? '', 15, '_') }}</strong>
                Matrícula: <strong>{{ str_pad($associado->matricula ?? '', 15, '_') }}</strong>
                OPM: <strong>{{ str_pad($associado->opm ?? '', 20, '_') }}</strong>
                Horário de trabalho: <strong>{{ str_pad($associado->horario_trabalho ?? '', 20, '_') }}</strong>
                <br>

                Nascido em: <strong>{{ str_pad(date('d/m/Y', strtotime($associado->dt_nasc)) ?? '', 30, '_') }}</strong>
                Filho(a) de: <strong>{{ str_pad($associado->nome_mae ?? '', 35, '_') }}</strong>,
                e <strong>{{ str_pad($associado->nome_pai ?? '', 35, '_') }}</strong>
                Endereço: <strong>{{ str_pad($associado->endereco->logradouro ?? '', 30, '_') }}</strong>
                <br>
                Número: <strong>{{ str_pad($associado->endereco->nmr ?? '', 20, '_') }}</strong>


                Bairro: <strong>{{ str_pad($associado->endereco->bairro ?? '', 20, '_') }}</strong>
                Cidade: <strong>{{ str_pad($associado->endereco->cidade ?? '', 20, '_') }}</strong>
                Complemento: <strong>{{ str_pad($associado->endereco->complemento ?? '', 60, '_') }}</strong>
                <br>

                Cursos Civis: <strong>{{ str_pad($associado->cursos_civis ?? '', 30, '_') }}</strong>
                Grau de Instrução: <strong>{{ str_pad($associado->grau_instrucao ?? '', 30, '_') }}</strong>
                <br>

                Telefone Celular: <strong>{{ str_pad($associado->contato->tel_celular ?? '', 25, '_') }}</strong>
                Telefone Residencial:
                <strong>{{ str_pad($associado->contato->tel_residencial ?? '', 25, '_') }}</strong>
                <br>

                Telefone Trabalho: <strong>{{ str_pad($associado->contato->tel_trabalho ?? '', 25, '_') }}</strong>
                E-mail: <strong>{{ str_pad($associado->contato->email ?? '', 43, '_') }}</strong>
                <br>





                Em caso de acidente avisar à: ___________________________
                Endereço: ________________________________
                <br>

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



        </div>

        <div class="assinatura">
            Natal/RN, ____ de __________________ de 20__ <br>

            <span>Assinatura</span>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print(); // Abre a janela de impressão automaticamente
        };
    </script>


</body>

</html>
