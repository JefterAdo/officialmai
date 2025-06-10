<section id="modernHeroSlider" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" style="margin-bottom: -5px;">
    @php
        $slides = App\Models\Slide::where('is_active', true)->orderBy('order')->get();
    @endphp
    
    <div class="carousel-indicators">
        @foreach($slides as $index => $slide)
            <button type="button" data-bs-target="#modernHeroSlider" data-bs-slide-to="{{ $index }}" 
                class="{{ $index === 0 ? 'active' : '' }}" 
                aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                aria-label="Slide {{ $index + 1 }}">
            </button>
        @endforeach
    </div>

    <div class="carousel-inner">
        @foreach($slides as $index => $slide)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }} slider-item" 
                style="background-image: url('{{ asset('storage/' . $slide->image_path) }}');">
                <div class="slider-overlay"></div>
                <div class="container slider-content-container">
                    <div class="row justify-content-center text-center">
                        <div class="col-lg-9 slider-content" data-aos="fade-up">
                            <h2 class="slider-title">{{ $slide->title }}</h2>
                            <p class="slider-description">{{ $slide->description }}</p>
                            @if($slide->button_text)
                                <div class="slider-cta-container mt-4">
                                    <a href="{{ $slide->button_link }}" class="btn btn-primary btn-lg slider-cta">
                                        {{ $slide->button_text }}
                                        @if(str_contains($slide->button_text, "J'adhère"))
                                            <i class="fas fa-user-plus ms-2"></i>
                                        @else
                                            <i class="fas fa-info-circle ms-2"></i>
                                        @endif
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#modernHeroSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#modernHeroSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</section>