@if($banners)
<div style="background-color: ;">

    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000"
        data-bs-pause="false">

        {{-- Indicadores (bolinhas) --}}
        <div class="carousel-indicators">
            @foreach ($banners as $index => $banner)
                <button type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide-to="{{ $index }}"
                    class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index + 1 }}">
                </button>
            @endforeach
        </div>

        {{-- Slides --}}
        <div class="carousel-inner">
            @foreach ($banners as $index => $banner)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img class="d-block w-100" src="{{ asset('storage/' . $banner->files->first()->path) }}"
                        alt="Slide {{ $index + 1 }}" style="height: 400px; object-fit: contain;">
                </div>
            @endforeach
        </div>

        {{-- Botão anterior --}}
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        {{-- Botão próximo --}}
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </div>

</div>
@endif