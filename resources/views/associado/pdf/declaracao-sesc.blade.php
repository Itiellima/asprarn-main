@extends('associado.pdf.layout')

@section('titulo', 'Declaração SESC')

@section('conteudo')
    <h4 class="titulo-documento" style="margin-top: 1.5cm">DECLARAÇÃO</h4>

    <div class="conteudo" style="margin-top: 1.5rem">
        <p>
            &nbsp;&nbsp; <strong>A Associação dos Praças da Polícia Militar do Estado do Rio Grande do Norte – ASPRA
                PMRN,</strong>
            inscrita no CNPJ sob o nº 05.786.841/0001-63, com sede na Rua João Pessoa, n° 267 – Edifício Cidade do
            Natal, 1° andar, sala 111 – Cidade Alta, Natal/RN, por meio de sua diretoria, declara para os devidos fins
            que:
        </p>
        <p>
            &nbsp;&nbsp;
            <span class="campo" contenteditable="true" data-placeholder="nome do associado">{{ $associado->nome }}</span>,
            inscrito no CPF sob o nº
            <span class="campo" contenteditable="true" data-placeholder="000.000.000-00">{{ $associado->cpf }}</span>
            e RG nº
            <span class="campo" contenteditable="true" data-placeholder="nº do RG">{{ $associado->rg }}</span>,
            <span class="campo" contenteditable="true" data-placeholder="órgão expedidor">{{ $associado->org_expedidor }}</span>,
            tem vínculo ativo com esta instituição.
        </p>
        <p>
            &nbsp;&nbsp; A presente declaração é emitida a pedido do interessado, para fins de <strong>obtenção da
                Credencial SESC,</strong>
            conforme convênio firmado entre esta Associação e o <strong>SESC RN (Nº
                <span class="campo" contenteditable="true" data-placeholder="nº do convênio">RN-2025-CON-RCC0033</span>),</strong>
            que assegura ao associado o acesso aos benefícios oferecidos pela instituição.
        </p>
    </div>

    <div class="text-center" style="margin-top: 3rem;">
        @include('associado.pdf.partials.data-local')
    </div>

    <div class="assinatura">
        <img src="/img/assinatura-pr.png" alt="Assinatura">
    </div>
@endsection
