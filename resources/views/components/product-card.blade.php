@props(['product'])

<a href="{{ route('contact.index', ['product' => $product->name]) }}" class="product-card">
    @if ($product->coverImageUrl())
        <img src="{{ $product->coverImageUrl() }}" alt="{{ $product->name }}" class="product-card__image">
    @else
        <div class="product-card__image"></div>
    @endif
    <div class="p-3">
        <p class="product-card__brand mb-1">{{ $product->brand->name }}</p>
        <h3 class="h6 mb-2 text-dark">{{ $product->name }}</h3>
        @if ($product->price)
            <p class="mb-0 product-card__price">
                @if ($product->price_label)
                    <span class="text-muted fw-normal">{{ $product->price_label }}</span>
                @endif
                &euro; {{ number_format((float) $product->price, 2, ',', '.') }}
            </p>
        @endif
    </div>
</a>
