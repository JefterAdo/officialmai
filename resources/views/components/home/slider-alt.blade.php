@php
$slides = \App\Models\Slide::where('is_active', true)->orderBy('order')->get();
@endphp

<div class="position-relative" style="z-index: 1; overflow: visible; will-change: transform; transform: translateZ(0);">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-carousel>
        <!-- Indicateurs -->
        <ol class="carousel-indicators" style="z-index: 5;">
            @foreach($slides as $index => $slide)
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}" data-carousel-indicator></button>
            @endforeach
        </ol>
        <div class="carousel-inner" style="backface-visibility: hidden;">
            @foreach($slides as $index => $slide)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-carousel-item style="height: 600px; transition: opacity 0.6s ease;">
                    <div style="height: 600px; background-image: url('/storage/{{ $slide->image_path }}'); background-size: cover; background-position: center; transition: transform 0.5s ease;" class="d-block w-100 h-100">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100">
                        <div class="bg-dark bg-opacity-50 p-4 rounded" style="width: 80%; max-width: 800px;">
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
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" data-carousel-prev>
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" data-carousel-next>
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>
</div>