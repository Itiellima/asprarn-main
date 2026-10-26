@extends('associado.pdf.layout')

@section('titulo', 'Requerimento de Desfiliação')

@section('conteudo')
    <p style="margin-top: 1cm">
        <strong>
            AO ILUSTRÍSSIMO SENHOR PRESIDENTE DA ASSOCIAÇÃO DOS PRAÇAS DA POLÍCIA MILITAR DO ESTADO DO RIO GRANDE DO
            NORTE - ASPRA PM/RN.
        </strong>
    </p>

    <h5 class="titulo-documento" style="margin-top: 1cm">REQUERIMENTO DE DESFILIAÇÃO</h5>

    <div class="conteudo" style="margin-top: 1.5rem">
        <p>
            &nbsp;&nbsp; Eu,
            <span class="campo linha" contenteditable="true" data-placeholder="nome do associado">{{ $associado->nome }}</span>,
            CPF:
            <span class="campo linha" contenteditable="true" data-placeholder="000.000.000-00">{{ $associado->cpf }}</span>,
            RG PM:
            <span class="campo linha" contenteditable="true" data-placeholder="nº do RG">{{ $associado->rg }}</span>,
            MATRÍCULA
            <span class="campo linha" contenteditable="true" data-placeholder="matrícula">{{ $associado->matricula }}</span>,
            vem mui respeitosamente perante vossa senhoria, requerer meu desligamento do quadro de associado da ASPRA
            PM/RN, rubrica 677, de acordo com o art. 5º, Inciso XX da Constituição Federal, por não interessar mais
            permanecer nos quadros desta entidade, desistindo ainda de todas as ações coletivas em andamento, em meu
            favor, tendo como substituto processual a ASPRA PM/RN.
        </p>
        <p>
            &nbsp;&nbsp; <strong>Fico ciente ainda, que, caso resolva reingressar nos quadros de associado da ASPRA
                PM/RN, terei que cumprir a carência conforme dispõe o Inciso “III” do parágrafo 3º do art. 50 do
                Estatuto Social da ASPRA PM/RN.</strong>
        </p>
    </div>

    <div style="margin-top: 2.5rem">
        <p>&nbsp;&nbsp;&nbsp;&nbsp;Nestes termos, pede e espera deferimento.</p>

        <p class="text-center" style="margin-top: 2rem">
            @include('associado.pdf.partials.data-local', ['emBranco' => true])
        </p>

        <div class="assinatura">
            <span class="linha-assinatura"></span>
            Requerente
        </div>
    </div>
@endsection
