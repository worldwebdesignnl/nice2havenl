@props(['store', 'index' => 1])

<div class="store-card">
    @if ($store->photoUrl())
        <img src="{{ $store->photoUrl() }}" alt="{{ $store->name }}" class="store-card__image">
    @else
        <div class="store-card__image store-card__image--placeholder store-card__image--{{ (($index - 1) % 2) + 1 }}"></div>
    @endif
    <div class="p-4">
        <h3 class="h5 font-display mb-3">Nice2Have {{ $store->name }}</h3>
        <div class="contact-line">
            <i class="bi bi-geo-alt-fill"></i>
            <span>{{ $store->address_line }}, {{ $store->postal_code }} {{ $store->city }}</span>
        </div>
        <div class="contact-line">
            <i class="bi bi-telephone-fill"></i>
            <span>{{ $store->phone }}</span>
        </div>
        @if ($store->openingHoursSummary())
            <div class="contact-line mb-3">
                <i class="bi bi-clock-fill"></i>
                <span>{{ ucfirst($store->openingHoursSummary()) }}</span>
            </div>
        @endif
        <a href="{{ route('store.show', $store->slug) }}" class="btn btn-outline-rose">Bezoek onze winkel</a>
    </div>
</div>
