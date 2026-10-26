@extends('associado.pdf.layout')

@section('titulo', 'Requerimento')

@php
    $endereco = $associado->endereco;
    $contato = $associado->contato;
    $nascimento = $associado->dt_nasc ? \Carbon\Carbon::parse($associado->dt_nasc)->format('d/m/Y') : '';
@endphp

@section('conteudo')
    <h4 class="titulo-documento" style="margin-top: 0.5cm">REQUERIMENTO</h4>

    <div class="conteudo compacto" style="margin-top: 1rem">
        <p>
            Sr Presidente,<br>
            Eu,
            <span class="campo linha" contenteditable="true" data-placeholder="nome completo">{{ $associado->nome }}</span>,
            inscrito sob CPF nº:
            <span class="campo linha" contenteditable="true" data-placeholder="000.000.000-00">{{ $associado->cpf }}</span>,
            RG:
            <span class="campo linha" contenteditable="true" data-placeholder="nº do RG">{{ $associado->rg }}</span>,
            Estado Civil:
            <span class="campo linha" contenteditable="true" data-placeholder="estado civil">{{ $associado->estado_civil }}</span>,
            Graduação:
            <span class="campo linha" contenteditable="true" data-placeholder="graduação">{{ $associado->graduacao }}</span>,
            Nº Praça:
            <span class="campo linha" contenteditable="true" data-placeholder="nº praça">{{ $associado->nmr_praca }}</span>,
            Matrícula:
            <span class="campo linha" contenteditable="true" data-placeholder="matrícula">{{ $associado->matricula }}</span>,
            OPM:
            <span class="campo linha" contenteditable="true" data-placeholder="OPM">{{ $associado->opm }}</span>,
            Horário de trabalho:
            <span class="campo linha" contenteditable="true" data-placeholder="horário">{{ $associado->horario_trabalho }}</span>,
            Nascido em:
            <span class="campo linha" contenteditable="true" data-placeholder="dd/mm/aaaa">{{ $nascimento }}</span>,
            Filho(a) de:
            <span class="campo linha" contenteditable="true" data-placeholder="nome da mãe">{{ $associado->nome_mae }}</span>
            e
            <span class="campo linha" contenteditable="true" data-placeholder="nome do pai">{{ $associado->nome_pai }}</span>,
            Endereço:
            <span class="campo linha" contenteditable="true" data-placeholder="logradouro">{{ $endereco?->logradouro }}</span>,
            Número:
            <span class="campo linha" contenteditable="true" data-placeholder="nº" style="min-width: 40px;">{{ $endereco?->nmr }}</span>,
            Bairro:
            <span class="campo linha" contenteditable="true" data-placeholder="bairro">{{ $endereco?->bairro }}</span>,
            Cidade:
            <span class="campo linha" contenteditable="true" data-placeholder="cidade">{{ $endereco?->cidade }}</span>,
            Complemento:
            <span class="campo linha" contenteditable="true" data-placeholder="complemento">{{ $endereco?->complemento }}</span>,
            Cursos Civis:
            <span class="campo linha" contenteditable="true" data-placeholder="cursos civis">{{ $associado->cursos_civis }}</span>,
            Grau de Instrução:
            <span class="campo linha" contenteditable="true" data-placeholder="grau de instrução">{{ $associado->grau_instrucao }}</span>,
            Telefone Celular:
            <span class="campo linha" contenteditable="true" data-placeholder="(84) 90000-0000">{{ $contato?->tel_celular }}</span>,
            Telefone Residencial:
            <span class="campo linha" contenteditable="true" data-placeholder="telefone">{{ $contato?->tel_residencial }}</span>,
            Telefone Trabalho:
            <span class="campo linha" contenteditable="true" data-placeholder="telefone">{{ $contato?->tel_trabalho }}</span>,
            E-mail:
            <span class="campo linha" contenteditable="true" data-placeholder="email@exemplo.com">{{ $contato?->email }}</span>.
        </p>

        <p>
            Em caso de acidente avisar à:
            <span class="campo linha" contenteditable="true" data-placeholder="nome" style="min-width: 220px;"></span>
            Endereço:
            <span class="campo linha" contenteditable="true" data-placeholder="endereço" style="min-width: 220px;"></span>
            Nº:
            <span class="campo linha" contenteditable="true" data-placeholder="nº" style="min-width: 40px;"></span>
            Bairro:
            <span class="campo linha" contenteditable="true" data-placeholder="bairro" style="min-width: 140px;"></span>
            Cidade:
            <span class="campo linha" contenteditable="true" data-placeholder="cidade" style="min-width: 140px;"></span>
            Telefone Celular:
            <span class="campo linha" contenteditable="true" data-placeholder="telefone" style="min-width: 120px;"></span>
            Telefone Residencial:
            <span class="campo linha" contenteditable="true" data-placeholder="telefone" style="min-width: 120px;"></span>
            Telefone Trabalho:
            <span class="campo linha" contenteditable="true" data-placeholder="telefone" style="min-width: 120px;"></span>.
        </p>

        <p>
            Venho, mui respeitosamente, REQUER a Vossa Excelência, a minha inscrição no quadro social desta entidade,
            como sócio
            <span class="campo linha" contenteditable="true" data-placeholder="categoria" style="min-width: 120px;"></span>,
            de acordo com a letra
            <span class="campo linha" contenteditable="true" data-placeholder="letra" style="min-width: 40px;"></span>,
            do art.
            <span class="campo linha" contenteditable="true" data-placeholder="art." style="min-width: 40px;"></span>
            e Inciso
            <span class="campo linha" contenteditable="true" data-placeholder="inciso" style="min-width: 40px;"></span>
            §§
            <span class="campo linha" contenteditable="true" data-placeholder="§" style="min-width: 30px;"></span>
            e
            <span class="campo linha" contenteditable="true" data-placeholder="§" style="min-width: 30px;"></span>,
            do art.
            <span class="campo linha" contenteditable="true" data-placeholder="art." style="min-width: 40px;"></span>,
            do Estatuto Social desta entidade, autorizando desde já o desconto da mensalidade ou despesas em folha de
            pagamento ou na Conta Nº:
            <span class="campo linha" contenteditable="true" data-placeholder="conta" style="min-width: 80px;"></span>
            Agência:
            <span class="campo linha" contenteditable="true" data-placeholder="agência" style="min-width: 60px;"></span>
            Banco:
            <span class="campo linha" contenteditable="true" data-placeholder="banco" style="min-width: 80px;"></span>
            Código para Débito Nº:
            <span class="campo linha" contenteditable="true" data-placeholder="código" style="min-width: 80px;"></span>
            Contrato de Convênio Nº:
            <span class="campo linha" contenteditable="true" data-placeholder="contrato" style="min-width: 80px;"></span>.
        </p>

        <img src="/img/dependentes.png" alt="Dependentes" class="img-fluid">
    </div>

    <div class="assinatura">
        @include('associado.pdf.partials.data-local', ['emBranco' => true])
        <span class="linha-assinatura"></span>
        Requerente
    </div>
@endsection

@section('rodape')
    <strong>
        <a href="https://www.asprarn.com">www.asprarn.com</a>, e-mail: asprarn@gmail.com, contatoasprarn@gmail.com
        <br>
        FONES: (84) 3201-0100 / 9.8823-0100
    </strong>
@endsection
