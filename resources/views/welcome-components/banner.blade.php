<div class="border text-center justify-center items-center" style="background-color: ;">

    {{-- <img src="{{ asset('/img/Aspra.png') }}" class="card-img-top" style="height: 400px; width: 100%; object-fit: contain;"
        alt="img"> --}}

    {{-- @foreach ($banners as $banner)
        <div class="carrousel-item">
            <img src="{{ asset('storage/' . $banner->files->first()->path) }}" alt="{{ $banner->id }}"
                class="card-img-top" style="height: 400px; width: 100%; object-fit: contain;">
        </div>
    @endforeach --}}

</div>


<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" data-bs-pause="false">
    <div class="carousel-inner">
        @foreach ($banners as $index => $banner)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $banner->files->first()->path) }}" alt="Slide {{ $index + 1 }}"
                    class="card-img-top" style="height: 400px; width: 100%; object-fit: contain;" class="d-block w-100">
            </div>
        @endforeach
    </div>
</div>
