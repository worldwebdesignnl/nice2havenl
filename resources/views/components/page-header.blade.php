@props(['kicker', 'title', 'subtitle' => null, 'breadcrumbs' => []])

<header class="page-header">
    <div class="container">
        @if (count($breadcrumbs))
            <nav class="page-header__breadcrumb small mb-3">
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
        <h1 class="page-header__title font-display fst-italic fw-bold text-white mb-3">{{ $title }}</h1>
        @if ($subtitle)
            <p class="page-header__subtitle text-white-50 mb-0" style="max-width: 640px;">{{ $subtitle }}</p>
        @endif
    </div>
</header>
