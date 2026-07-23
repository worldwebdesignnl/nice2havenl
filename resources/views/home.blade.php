<x-layout>
    @push('schema')
        <x-schema :data="app(\App\Services\SchemaService::class)->organization()" />
    @endpush

    <x-hero-slider :slides="$slides" />

    <x-brand-ticker :brands="$brands" />

    <section class="py-5">
        <div class="container text-center">
            <p class="kicker mb-2">Welkom bij Nice2Have</p>
            <h1 class="font-display mb-4">Waar elke vrouw zich op haar gemak voelt</h1>
        </div>
        <x-usp-blocks :blocks="$uspBlocks" />
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-4">
                <p class="kicker mb-2">Ons assortiment</p>
                <h2 class="font-display mb-2">Ontdek onze collecties</h2>
                <p class="text-muted">Ons assortiment wisselt continu — dit is een selectie. Het volledige aanbod ontdek je in de winkel.</p>
            </div>
            <div class="row row-cols-2 row-cols-md-5 g-4">
                @foreach ($categories as $category)
                    <div class="col">
                        <x-category-tile :category="$category" :index="$loop->iteration" />
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('brand.index') }}" class="btn btn-outline-rose">Onze merken</a>
            </div>
        </div>
    </section>

    <section id="winkels" class="py-5">
        <div class="container">
            <div class="text-center mb-4">
                <p class="kicker mb-2">Onze winkels</p>
                <h2 class="font-display mb-2">Je vindt ons in Heerhugowaard &amp; Castricum</h2>
            </div>
            <div class="row g-4">
                @foreach ($stores as $store)
                    <div class="col-md-6">
                        <x-store-card :store="$store" :index="$loop->iteration" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5 cta-dark text-center">
        <div class="container" style="max-width: 800px;">
            <p class="kicker mb-2">Kom je ook langs?</p>
            <h2 class="font-display text-white mb-3">Zien, voelen en passen doe je in de winkel</h2>
            <p class="mb-4">Ons assortiment wisselt continu. Online lichten we per categorie onze favorieten uit. De rest ontdek je bij ons in de winkel.</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('category.show', 'tassen') }}" class="btn btn-rose btn-lg">Bekijk tassen</a>
                <a href="{{ route('store.show', 'heerhugowaard') }}" class="btn btn-outline-light btn-lg">Bezoek onze winkel</a>
            </div>
        </div>
    </section>
</x-layout>
