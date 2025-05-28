@php
$slides = \App\Models\Slide::where('is_active', true)->orderBy('order')->get();
@endphp

<div class="hero-carousel-container">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-carousel>
        <!-- Indicateurs -->
        <div class="carousel-indicators">
            @foreach($slides as $index => $slide)
                <button type="button" data-target="#heroCarousel" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}" data-carousel-indicator></button>
            @endforeach
        </div>
        
        <div class="carousel-inner">
            @foreach($slides as $index => $slide)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-carousel-item>
                    <div class="carousel-item-bg" style="background-image: url('/storage/{{ $slide->image_path }}');">
                        <div class="carousel-caption">
                            <div class="caption-content bg-dark bg-opacity-50 p-4 rounded">
                                <h2 class="display-4 fw-bold mb-4">{{ $slide->title }}</h2>
                                @if($slide->description)
                                    <p class="fs-4 mb-5">{{ $slide->description }}</p>
                                @endif
                                @if($slide->button_text && $slide->button_link)
                                    <a href="{{ $slide->button_link }}" class="btn btn-primary btn-lg slider-cta">
                                        {{ $slide->button_text }}
                                        @if(str_contains($slide->button_text, "J'adhère"))
                                            <i class="fas fa-user-plus ms-2"></i>
                                        @else
                                            <i class="fas fa-info-circle ms-2"></i>
                                        @endif
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <button class="carousel-control-prev" type="button" data-target="#heroCarousel" data-slide="prev" data-carousel-prev>
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#heroCarousel" data-slide="next" data-carousel-next>
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>
</div>