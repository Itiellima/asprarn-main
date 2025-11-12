@extends('layouts.main')

@section('title', 'AspraRN - Quem Somos')

@section('content')

<div class="container my-5">

    <h1 class="text-center mb-4" style="color: #0a499c;  font-size: 3rem;">
        <strong>QUEM SOMOS</strong>
    </h1>

    <div class="row align-items-center">

        <!-- Texto -->
        <div class="col-lg-7">
            <p class="mt-3 text-justify" style="text-align: justify">
                &nbsp;&nbsp;
                Desde 2003, a <strong>Associação dos Praças da Polícia Militar do Rio Grande do Norte (ASPRA PM/RN)</strong>
                tem sido a principal voz na defesa, valorização e proteção dos praças da corporação.
                <strong>Fundada por praças que compreendem, na prática, as dificuldades, os desafios e as conquistas
                    de quem está na linha de frente</strong>, a ASPRA PM/RN nasceu do compromisso de lutar por direitos,
                dignidade e reconhecimento àqueles que dedicam suas vidas à segurança da sociedade potiguar.
            </p>

            <p class="text-justify" style="text-align: justify">
                &nbsp;&nbsp;
                Ao longo de sua trajetória, a associação consolidou-se como referência em assistência jurídica,
                ações coletivas, apoio social e institucional, sempre pautada na transparência, na união e na
                representatividade.
                <strong>Cada avanço alcançado é fruto da força coletiva e da confiança dos praças que acreditam
                    em um futuro mais justo e valorizado para a categoria.</strong>
            </p>

            <p class="text-justify" style="text-align: justify">
                &nbsp;&nbsp;
                Mais do que uma entidade de classe, a ASPRA PM/RN é uma
                <strong>família formada por homens e mulheres que conhecem a realidade da tropa</strong>,
                que acolhe, orienta e luta lado a lado com cada associado, sempre em defesa de seus direitos
                e da dignidade da farda.
            </p>
        </div>

        <!-- Imagem -->
        <div class="col-lg-5 text-center mt-4 mt-lg-0">
            <img src="{{ asset('img/quemsomos.jpeg') }}" alt="Quem Somos - ASPRA PM/RN"
                 class="img-fluid rounded shadow-sm" style="max-width: 90%;">
        </div>

    </div>

    <div class="text-center mt-5">
        <p class="fw-bold">
            ASPRA PM/RN - Cuidando de quem cuida e protege a nossa sociedade.
        </p>
    </div>

</div>

@endsection
