@props(['kicker', 'title', 'subtitle' => null, 'image' => null, 'word' => null, 'breadcrumbs' => []])

<header class="page-hero-cine">
    @if ($image)
        <div class="phc-bg" style="background-image: url('{{ $image }}');"></div>
    @endif
    <div class="phc-overlay"></div>
    <span class="hero-word" aria-hidden="true">{{ $word ?? $title }}</span>
    <div class="container phc-content">
        @if (count($breadcrumbs))
            <nav class="page-hero-cine__breadcrumb small mb-3">
                @foreach ($breadcrumbs as $crumb)
                    @if (!$loop->first)
                        <span class="mx-1">/</span>
                    @endif
                    @if ($loop->last)
                        <span>{{ $crumb['label'] }}</span>
                    @else
                        <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                    @endif
                @endforeach
            </nav>
        @endif
        <p class="kicker mb-2">{{ $kicker }}</p>
        <h1 class="page-hero-cine__title mb-3">{{ $title }}</h1>
        @if ($subtitle)
            <p class="hero-sub mb-0">{{ $subtitle }}</p>
        @endif
    </div>
</header>
