@props(['slides'])

<div class="hero-cine" data-hero-slider>
    @foreach ($slides as $i => $slide)
        <div class="cine-slide {{ $i === 0 ? 'is-active' : '' }}">
            @if ($slide->imageUrl())
                <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->title }}" class="cine-slide__image">
            @endif
            <div class="cine-slide__overlay"></div>
            <div class="container h-100">
                <div class="cine-slide__content">
                    @if ($slide->kicker)
                        <p class="kicker mb-2">{{ $slide->kicker }}</p>
                    @endif
                    <h1 class="display-4 font-display fst-italic fw-bold mb-3">{{ $slide->title }}</h1>
                    @if ($slide->subtitle)
                        <p class="fs-5 mb-4">{{ $slide->subtitle }}</p>
                    @endif
                    @if ($slide->button_label && $slide->button_url)
                        <a href="{{ $slide->button_url }}" class="btn btn-rose btn-lg align-self-start">{{ $slide->button_label }}</a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    @if ($slides->count() > 1)
        <div class="hero-nav-arrows">
            <button type="button" class="hero-nav-arrow" data-hero-prev aria-label="Vorige"><i class="bi bi-arrow-left"></i></button>
            <button type="button" class="hero-nav-arrow" data-hero-next aria-label="Volgende"><i class="bi bi-arrow-right"></i></button>
        </div>

        <div class="hero-progress">
            @foreach ($slides as $i => $slide)
                <div class="hero-progress__bar {{ $i === 0 ? 'is-active' : '' }}"><span></span></div>
            @endforeach
        </div>
    @endif
</div>
