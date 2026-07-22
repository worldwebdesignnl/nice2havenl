<x-layout :meta-title="$category->meta_title ?: $category->name.' — Nice2Have'" :meta-description="$category->meta_description">
    @push('schema')
        <x-schema :data="app(\App\Services\SchemaService::class)->breadcrumb([
            ['name' => 'Home', 'url' => route('home')],
            ['name' => $category->name, 'url' => route('category.show', $category->slug)],
        ])" />
    @endpush

    <x-page-header
        kicker="Collectie"
        :title="$category->name"
        :subtitle="$category->description"
        :breadcrumbs="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => $category->name],
        ]"
    />

    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-4">
                <p class="kicker mb-2">Uitgelicht</p>
                <h2 class="font-display mb-2">Onze favorieten van dit moment</h2>
                <p class="text-muted mb-0">Ons assortiment wisselt continu. Hieronder zie je een greep uit wat er nu in de winkel ligt.</p>
            </div>

            <div class="row g-4">
                @forelse ($products as $product)
                    <div class="col-md-3 col-6">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <p class="text-muted text-center mb-0">Op dit moment geen uitgelichte producten in deze categorie — kom langs in de winkel voor het volledige assortiment.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-5 text-center" style="background-color: var(--cream);">
        <div class="container" style="max-width: 560px;">
            <h2 class="font-display mb-3">Twijfel je wat bij je past?</h2>
            <p class="text-muted mb-4">Onze medewerkers denken graag met je mee. Kom langs in Heerhugowaard of Castricum en probeer ze allemaal.</p>
            <a href="{{ route('home').'#winkels' }}" class="btn btn-rose">Bekijk onze winkels</a>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-md-6">
                    @if ($category->featurePhotoUrl())
                        <img src="{{ $category->featurePhotoUrl() }}" alt="{{ $category->name }}" class="feature-image">
                    @else
                        <div class="feature-image cat-card--{{ ((($category->id - 1) % 4) + 1) }}"></div>
                    @endif
                </div>
                <div class="col-md-6">
                    <p class="kicker mb-2">Waarom Nice2Have</p>
                    <h2 class="font-display mb-3">Elke week nieuwe binnenkomers</h2>
                    <p class="mb-3">Wij volgen de trends op de voet en kopen daarom vaak en klein in. Zo is er altijd wel iets nieuws te ontdekken als je bij ons langskomt.</p>
                    <ul class="check-list">
                        @if ($brands->isNotEmpty())
                            <li><i class="bi bi-check-circle-fill"></i>Merken als {{ $brands->pluck('name')->join(', ', ' en ') }}</li>
                        @endif
                        <li><i class="bi bi-check-circle-fill"></i>Prijzen waar je wat voor terugkrijgt</li>
                        <li><i class="bi bi-check-circle-fill"></i>Eerlijk en persoonlijk advies in de winkel</li>
                        <li><i class="bi bi-check-circle-fill"></i>Ruilen altijd, in leuke verpakking</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    @if ($brands->isNotEmpty())
        <section class="py-5" style="background-color: var(--cream);">
            <div class="container">
                <div class="text-center mb-4">
                    <p class="kicker mb-2">Onze topmerken</p>
                    <h2 class="font-display mb-2">Merken met eigen karakter</h2>
                    <p class="text-muted mb-0">Dit zijn de merken die je in deze categorie het vaakst tegenkomt.</p>
                </div>
                <div class="row g-4">
                    @foreach ($brands as $brand)
                        <div class="col-md-4">
                            <div class="brand-card">
                                @if ($brand->logoUrl())
                                    <img src="{{ $brand->logoUrl() }}" alt="{{ $brand->name }}" class="mb-3" style="max-height: 48px;">
                                @endif
                                <h3 class="h5 font-display mb-2">
                                    <a href="{{ route('brand.show', $brand->slug) }}" class="text-decoration-none text-dark">{{ $brand->name }}</a>
                                </h3>
                                @if ($brand->description)
                                    <p class="text-muted mb-0">{{ $brand->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-md-6 order-md-2">
                    @if ($category->giftPhotoUrl())
                        <img src="{{ $category->giftPhotoUrl() }}" alt="{{ $category->name }}" class="feature-image">
                    @else
                        <div class="feature-image cat-card--{{ (($category->id % 4) + 1) }}"></div>
                    @endif
                </div>
                <div class="col-md-6 order-md-1">
                    <p class="kicker mb-2">Cadeautip</p>
                    <h2 class="font-display mb-3">Twijfel je nog? Een cadeaubon is altijd goed.</h2>
                    <p class="mb-4">Weet je niet zeker wat iemand mooi vindt? Bij Nice2Have haal je in de winkel een cadeaubon, in te vullen naar eigen wens.</p>
                    <a href="{{ route('contact.index') }}" class="btn btn-outline-rose">Neem contact op</a>
                </div>
            </div>
        </div>
    </section>
</x-layout>
