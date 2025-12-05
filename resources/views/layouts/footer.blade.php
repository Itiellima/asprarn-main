<div class="container py-4 text-white mt-3">
    <div class="row align-items-center mb-3">

        <!-- Coluna 1: Logo e horário -->
        <div class="col-md-3 mb-4 mb-md-0 text-center text-md-start">
            <a href="/" class="d-inline-flex align-items-center text-decoration-none">
                <img src="{{ asset('img/ASPRA-branco.png') }}" alt="Logo ASPRA RN" width="img-fluid" height="120" class="me-2">
            </a>
            <div class="mt-2 small">
                <p class="mb-1 fw-bold">Horário de funcionamento:</p>
                <p class="mb-1">Segunda a sexta</p>
                <p class="mb-1">Das 8h às 12h e das 13h às 16h</p>
                <p class="mb-0">&copy; {{ date('Y') }} ASPRA RN</p>
            </div>
        </div>

        <!-- Coluna 2: Mensagem -->
        <div class="col-md-6 mb-4 mb-md-0 text-center">
            <p class="mb-1 fw-semibold">
                ASPRA PM/RN - Cuidando de quem cuida e protege a nossa sociedade.
            </p>
            {{-- <p class="small">Rua João Pessoa, 267, sala 111, edifício Cidade do Natal, Cidade Alta, Natal/RN</p> --}}
        </div>

        <!-- Coluna 3: Contatos -->
        <div class="col-md-3 text-center text-md-end">
            <p class="mb-2">
                <a href="https://www.instagram.com/associacaosdospracas/" target="_blank" rel="noopener noreferrer"
                    class="text-white d-inline-flex align-items-center gap-2 text-decoration-none">
                    <img src="{{ asset('img/Instagram_logo.svg') }}" alt="Instagram" width="26" height="26"
                        class="rounded">
                    <span>NOSSO INSTAGRAM</span>
                </a>
            </p>
            <p class="mb-2">
                <a href="https://wa.me/message/ABFVUULB5HXIK1" target="_blank" rel="noopener noreferrer"
                    class="text-white d-inline-flex align-items-center gap-2 text-decoration-none">
                    <img src="{{ asset('img/whatsapp.png') }}" alt="WhatsApp" width="26" height="26"
                        class="rounded">
                    <span>WHATSAPP ADM</span>
                </a>
            </p>
            <p class="mb-0">
                <a href="https://wa.me/message/CSTBYW7FREMVF1" target="_blank" rel="noopener noreferrer"
                    class="text-white d-inline-flex align-items-center gap-2 text-decoration-none">
                    <img src="{{ asset('img/whatsapp.png') }}" alt="WhatsApp" width="26" height="26"
                        class="rounded">
                    <span>WHATSAPP JURÍDICO</span>
                </a>
            </p>
        </div>

    </div>

    <!-- Mapa -->
    <div class="ratio ratio-16x9 mx-auto" style="max-width: 900px; border-radius: 10px; overflow: hidden;">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3969.4810239672665!2d-35.207228326167765!3d-5.787517657109735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7b30072b23939b1%3A0x1d12cb146921d277!2sASPRA%20PM%2FRN!5e0!3m2!1spt-BR!2sbr!4v1762864925560!5m2!1spt-BR!2sbr"
            style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>
