<x-layout
    meta-title="Contact — Nice2Have"
    meta-description="Vragen over een product of nieuwe collectie? We horen graag van je."
>
    <x-page-header
        kicker="Nice2Have"
        title="Contact"
        subtitle="Vragen over een product of nieuwe collectie? We horen graag van je."
        :breadcrumbs="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Contact'],
        ]"
    />

    <section class="py-5">
        <div class="container">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="row g-5">
                <div class="col-lg-7">
                    <p class="kicker mb-2">Stuur een bericht</p>
                    <h2 class="font-display mb-4">We reageren binnen één werkdag</h2>

                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        @honeypot

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Naam</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Je naam" class="form-control @error('first_name') is-invalid @enderror">
                                @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Telefoon</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="06-12 34 56 78" class="form-control @error('phone') is-invalid @enderror">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Winkel</label>
                                <select name="store_id" class="form-select @error('store_id') is-invalid @enderror">
                                    <option value="">Maakt niet uit</option>
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}" @selected(old('store_id', request('store')) == $store->id)>{{ $store->name }}</option>
                                    @endforeach
                                </select>
                                @error('store_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Onderwerp</label>
                                <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Waar gaat je vraag over?" class="form-control @error('subject') is-invalid @enderror">
                                @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Bericht</label>
                                <textarea name="message" rows="5" placeholder="Typ hier je bericht..." class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                                @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 form-check">
                                <input type="checkbox" name="privacy_accepted" value="1" class="form-check-input @error('privacy_accepted') is-invalid @enderror" id="privacyAccepted">
                                <label class="form-check-label" for="privacyAccepted">
                                    Ik ga akkoord met de verwerking van mijn gegevens conform het privacybeleid.
                                </label>
                                @error('privacy_accepted') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-rose">Verstuur bericht</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-5">
                    <p class="kicker mb-2">Direct contact</p>
                    <h2 class="font-display mb-4">Liever bellen of mailen?</h2>

                    @foreach ($stores as $store)
                        <div class="contact-line">
                            <i class="bi bi-telephone-fill"></i>
                            <span><strong>{{ $store->name }}</strong><br><a href="tel:{{ $store->phone }}">{{ $store->phone }}</a></span>
                        </div>
                    @endforeach

                    @if (!empty($organization['email']))
                        <div class="contact-line">
                            <i class="bi bi-envelope-fill"></i>
                            <a href="mailto:{{ $organization['email'] }}">{{ $organization['email'] }}</a>
                        </div>
                    @endif

                    @if (!empty($organization['instagram_url']) || !empty($organization['facebook_url']))
                        <div class="contact-line">
                            <i class="bi bi-share-fill"></i>
                            <span>
                                Volg ons op
                                @if (!empty($organization['instagram_url']))
                                    <a href="{{ $organization['instagram_url'] }}" target="_blank" rel="noopener">Instagram</a>
                                @endif
                                @if (!empty($organization['instagram_url']) && !empty($organization['facebook_url']))
                                    en
                                @endif
                                @if (!empty($organization['facebook_url']))
                                    <a href="{{ $organization['facebook_url'] }}" target="_blank" rel="noopener">Facebook</a>
                                @endif
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-4">
                <p class="kicker mb-2">Liever langskomen?</p>
                <h2 class="font-display mb-0">Bezoek een van onze winkels</h2>
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
</x-layout>
