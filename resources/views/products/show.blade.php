<x-layout :meta-title="$product->meta_title ?: $product->name.' — Nice2Have'" :meta-description="$product->meta_description">
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-6">
                    @if ($product->coverImageUrl('medium'))
                        <img src="{{ $product->coverImageUrl('medium') }}" alt="{{ $product->name }}" class="img-fluid">
                    @else
                        <div class="product-card__image" style="height: 420px;"></div>
                    @endif
                </div>
                <div class="col-md-6">
                    <p class="product-card__brand mb-2">{{ $product->brand->name }}</p>
                    <h1 class="font-display mb-3">{{ $product->name }}</h1>
                    @if ($product->price)
                        <p class="fs-4 fw-semibold mb-3">
                            @if ($product->price_label)
                                <span class="text-muted fw-normal fs-6">{{ $product->price_label }}</span>
                            @endif
                            &euro; {{ number_format((float) $product->price, 2, ',', '.') }}
                        </p>
                    @endif
                    @if ($product->short_description)
                        <p class="mb-3">{{ $product->short_description }}</p>
                    @endif
                    @if ($product->description)
                        <p class="text-muted">{{ $product->description }}</p>
                    @endif
                    <a href="{{ route('contact.index') }}" class="btn btn-rose mt-3">Vraag naar dit product</a>
                </div>
            </div>

            @if ($related->isNotEmpty())
                <div class="mt-5">
                    <h2 class="h4 font-display mb-4">Ook interessant</h2>
                    <div class="row g-4">
                        @foreach ($related as $item)
                            <div class="col-md-3 col-6">
                                <x-product-card :product="$item" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-layout>
