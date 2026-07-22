<x-layout meta-title="Merken — Nice2Have">
    <x-page-header
        kicker="Merken"
        title="Toonaangevende merken"
        subtitle="Een zorgvuldig samengestelde selectie van merken die je overal ziet terugkomen."
        :breadcrumbs="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Merken'],
        ]"
    />

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @foreach ($brands as $brand)
                    <div class="col-md-4 col-6">
                        <a href="{{ route('brand.show', $brand->slug) }}" class="text-decoration-none text-dark">
                            <div class="store-card p-4 h-100">
                                @if ($brand->logoUrl())
                                    <img src="{{ $brand->logoUrl() }}" alt="{{ $brand->name }}" class="mb-3" style="max-height: 60px;">
                                @endif
                                <h3 class="h5 font-display">{{ $brand->name }}</h3>
                                @if ($brand->description)
                                    <p class="text-muted mb-0">{{ strip_tags($brand->description) }}</p>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>
