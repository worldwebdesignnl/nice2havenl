<x-layout :meta-title="$brand->meta_title ?: $brand->name.' — Nice2Have'" :meta-description="$brand->meta_description">
    <section class="py-5">
        <div class="container">
            <p class="kicker mb-2">Merk</p>
            <h1 class="font-display mb-3">{{ $brand->name }}</h1>
            @if ($brand->description)
                <p class="text-muted mb-4" style="max-width: 640px;">{{ $brand->description }}</p>
            @endif

            <div class="row g-4">
                @forelse ($products as $product)
                    <div class="col-md-3 col-6">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <p class="text-muted">Op dit moment geen uitgelichte producten van dit merk — kom langs in de winkel voor het volledige assortiment.</p>
                @endforelse
            </div>
        </div>
    </section>
</x-layout>
