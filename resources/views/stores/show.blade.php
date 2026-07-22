<x-layout :meta-title="$store->meta_title ?: 'Winkel '.$store->name.' — Nice2Have'" :meta-description="$store->meta_description">
    @push('schema')
        <x-schema :data="app(\App\Services\SchemaService::class)->localBusiness($store)" />
        <x-schema :data="app(\App\Services\SchemaService::class)->breadcrumb([
            ['name' => 'Home', 'url' => route('home')],
            ['name' => $store->name, 'url' => route('store.show', $store->slug)],
        ])" />
    @endpush

    <x-page-header
        kicker="Onze winkel"
        :title="'Nice2Have '.$store->name"
        :subtitle="$store->description"
        :breadcrumbs="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => $store->name],
        ]"
    />

    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-6">
                    <p class="kicker mb-2">Winkel</p>
                    <h2 class="font-display mb-3">Nice2Have {{ $store->name }}</h2>

                    <div class="contact-line">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>{{ $store->address_line }}<br>{{ $store->postal_code }} {{ $store->city }}</span>
                    </div>
                    <div class="contact-line">
                        <i class="bi bi-telephone-fill"></i>
                        <span>{{ $store->phone }}</span>
                    </div>
                    <div class="contact-line mb-2">
                        <i class="bi bi-clock-fill"></i>
                        <span>
                            <strong>Openingstijden</strong><br>
                            @foreach ($store->openingHoursGrouped() as $line)
                                {{ $line['label'] }}: {{ $line['hours'] }}<br>
                            @endforeach
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <x-map-embed :store="$store" />
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-md-6">
                    @if ($store->areaPhotoUrl())
                        <img src="{{ $store->areaPhotoUrl() }}" alt="{{ $store->shoppingCenterShortName() }}" class="feature-image">
                    @else
                        <div class="feature-image cat-card--{{ (($store->id - 1) % 4) + 1 }}"></div>
                    @endif
                </div>
                <div class="col-md-6">
                    <p class="kicker mb-2">Goed om te weten</p>
                    <h2 class="font-display mb-3">Winkelen in {{ $store->shoppingCenterShortName() ?? $store->city }}</h2>
                    <p class="mb-3">Onze winkel in {{ $store->city }} vind je in {{ $store->shopping_center ?: 'het centrum' }}. Parkeren doe je gratis, direct bij het winkelpand.</p>
                    <ul class="check-list">
                        @if ($store->shopping_center)
                            <li><i class="bi bi-check-circle-fill"></i>In {{ $store->shopping_center }}</li>
                        @endif
                        <li><i class="bi bi-check-circle-fill"></i>Gratis parkeren bij de deur</li>
                        <li><i class="bi bi-check-circle-fill"></i>Persoonlijk advies en alle tijd voor je</li>
                        <li><i class="bi bi-check-circle-fill"></i>Cadeautje? Wij pakken het gratis in</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    @if ($otherStores->isNotEmpty())
        @php $otherStore = $otherStores->first(); @endphp
        <section class="py-5 cta-dark text-center">
            <div class="container" style="max-width: 640px;">
                <p class="kicker mb-2">Ook handig</p>
                <h2 class="font-display text-white mb-3">Je vindt ons ook in {{ $otherStore->name }}</h2>
                <p class="mb-4">Beide winkels hebben hun eigen sfeer en een eigen selectie. Ruilen kan altijd in beide vestigingen.</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('store.show', $otherStore->slug) }}" class="btn btn-rose">Bezoek {{ $otherStore->name }}</a>
                    <a href="{{ route('contact.index') }}" class="btn btn-outline-light">Stel een vraag</a>
                </div>
            </div>
        </section>
    @endif
</x-layout>
