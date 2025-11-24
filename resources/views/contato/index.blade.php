@extends('layouts.main')

@section('title', 'AspraRn - Contatos')

@section('content')

    <div class="container">

        <div class="justify-content text-center m-5">
            <h1 class="text-center mb-4" style="color: #0a499c;  font-size: 2rem;">
                <strong>Estamos à disposição para tirar dúvidas, receber sugestões ou ajudar você no que for
                    preciso.</strong>
            </h1>
        </div>

        <div class="row mt-3">

            <div class="col-lg-4">
                <h2 style="color: #0a499c">Entre em Contato:</h2>
                <p><strong>Telefone:</strong> +55 (84) 8823-0100</p>
                <p><strong>E-mail:</strong> contatoasprarn@gmail.com</p>
                <p><strong>E-mail:</strong> juridicoasprarn@gmail.com</p>
                <p><strong>Endereço:</strong> Rua João Pessoa, 267, salas 111 e 716 - Cidade Alta, Natal - RN, 59025-500</p>
                <p><strong>Horário de Atendimento:</strong> Segunda a Sexta, Das 8h às 12h e das 13h às 16h</p>
            </div>

            <div class="col-lg-4">
                <h2 class="text-center" style="color: #0a499c">Informações Institucionais:</h2>

                {{-- <p>CNPJ: 05.786.741/0001-63</p> --}}
                
                <p>Associação dos Praças da Polícia Militar do RN - Aspra Pm RN</p>

                {{-- <p>Presidente/Diretor responsável: </p> --}}

                ASPRA PM/RN - Cuidando de quem cuida e protege a nossa sociedade.
            </div>

            <div class="col-lg-4">
                <h2 style="color: #0a499c">
                    Redes sociais e WhatsApp:
                </h2>
                <p class="mb-2">
                    <a href="https://www.instagram.com/associacaosdospracas/" target="_blank" rel="noopener noreferrer"
                        class="d-inline-flex align-items-center gap-2 text-decoration-none">
                        <img src="{{ asset('img/Instagram_logo.svg') }}" alt="Instagram" width="26" height="26"
                            class="rounded">
                        <span>NOSSO INSTAGRAM</span>
                    </a>
                </p>
                <p class="mb-2">
                    <a href="https://wa.me/message/ABFVUULB5HXIK1" target="_blank" rel="noopener noreferrer"
                        class="d-inline-flex align-items-center gap-2 text-decoration-none">
                        <img src="{{ asset('img/whatsapp.png') }}" alt="WhatsApp" width="26" height="26"
                            class="rounded">
                        <span>WHATSAPP ADM</span>
                    </a>
                </p>
                <p class="mb-0">
                    <a href="https://wa.me/message/CSTBYW7FREMVF1" target="_blank" rel="noopener noreferrer"
                        class="d-inline-flex align-items-center gap-2 text-decoration-none">
                        <img src="{{ asset('img/whatsapp.png') }}" alt="WhatsApp" width="26" height="26"
                            class="rounded">
                        <span>WHATSAPP JURÍDICO</span>
                    </a>
                </p>
            </div>

        </div>
    </div>










@endsection
