<x-layout :meta-title="$brand->meta_title ?: $brand->name.' — Nice2Have'" :meta-description="$brand->meta_description">
    @push('schema')
        <x-schema :data="app(\App\Services\SchemaService::class)->breadcrumb([
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Merken', 'url' => route('brand.index')],
            ['name' => $brand->name, 'url' => route('brand.show', $brand->slug)],
        ])" />
    @endpush

    <x-page-header
        kicker="Merk"
        :title="$brand->name"
        :subtitle="$brand->description ? strip_tags($brand->description) : null"
        :breadcrumbs="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Merken', 'url' => route('brand.index')],
            ['label' => $brand->name],
        ]"
    />

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @forelse ($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <p class="text-muted">Op dit moment geen uitgelichte producten van dit merk — kom langs in de winkel voor het volledige assortiment.</p>
                @endforelse
            </div>
        </div>
    </section>
</x-layout>
