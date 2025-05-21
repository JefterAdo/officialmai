@php
$slides = \App\Models\Slide::where('is_active', true)->orderBy('order')->get();
@endphp

<div class="position-relative">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($slides as $index => $slide)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" style="height: 600px;">
                    <div style="height: 600px; background-image: url('/storage/{{ $slide->image_path }}'); background-size: cover; background-position: center;" class="d-block w-100 h-100">
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
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>
</div>
        items: 1,
        loop: true,
        margin: 0,
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        navText: ['', ''],
        navElement: 'div',
        responsive: {
            0: {
                nav: false
            },
            768: {
                nav: true
            }
        }
    });

    // Custom navigation
    $('.prev-button').click(function() {
        $('.slide-carousel').trigger('prev.owl.carousel');
    });

    $('.next-button').click(function() {
        $('.slide-carousel').trigger('next.owl.carousel');
    });
});
</script>
@endpush 