<style>
    .post-media {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 6px;
        margin-block-end: auto;
        box-shadow: 5px 5px 5px #1e1d1d;
    }

    /* Remove barras pretas dos vídeos */
    .post-media video {
        background: #000;
    }

    .owl-carousel .item {
        width: 100%;
        height: 300px;
        /* Ajuste aqui a altura desejada */
        /* overflow: hidden; */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .instagram-post {
        background: #0a499c;
        padding-top: 50px;
        padding-left: 50px;
        padding-right: 50px;
    }
</style>


<div class="instagram-post mt-3">
    <h3 class="text-white mb-4"><a href="https://www.instagram.com/associacaosdospracas/" target="_blank" style="color: white">Siga-nos no Instagram</a></h3>

    <div wire:ignore>
        <div class="owl-carousel owl-theme">
            @if (empty($instagram))
            @else
                @foreach ($instagram as $post)
                    <div class="item">
                        @if ($post['media_type'] === 'VIDEO')
                            <video class="post-media" controls src="{{ $post['media_url'] }}" alt="Vídeo do Instagram"
                                style="max-width: 200px;"></video>
                        @else
                            {{-- Para IMAGE ou CAROUSEL_ALBUM --}}
                            <a href="{{ $post['permalink'] }}" target="_blank">
                                <img class="post-media" src="{{ $post['media_url'] ?? $post['thumbnail_url'] }}"
                                    alt="{{ $post['caption'] ?? 'Post do Instagram' }}" style="max-width: 200px;">
                            </a>
                        @endif
                    </div>

                    {{-- 2. Exibir a Legenda
                <p class="caption">{{ Str::limit($post['caption'] ?? '', 100) }}</p>

                3. Link para o Post
                <a href="{{ $post['permalink'] }}" target="_blank">Ver no Instagram</a> --}}
                @endforeach
            @endif

        </div>
    </div>

</div>



@push('scripts')
    <script>
        function iniciarOwl() {
            const $carousel = $(".owl-carousel");

            // Se já existir um carrossel inicializado, destruímos
            if ($carousel.hasClass('owl-loaded')) {
                $carousel.trigger('destroy.owl.carousel');
                $carousel.html($carousel.find('.owl-stage-outer').html());
            }

            $carousel.owlCarousel({
                items: 5,
                loop: true,
                margin: 2,
                nav: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                slideBy: 1,

                responsive: {
                    0: {
                        items: 2
                    },
                    600: {
                        items: 3
                    },
                    900: {
                        items: 4
                    },
                    1200: {
                        items: 5
                    }
                }

            });
        }

        document.addEventListener("livewire:initialized", () => {
            // roda quando o componente carrega
            iniciarOwl();

            // roda sempre que o Livewire atualizar o DOM
            Livewire.hook('message.processed', (message, component) => {
                iniciarOwl();
            });
        });
    </script>
@endpush
