<footer class="site-footer py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="font-display text-white">Nice2Have</h5>
                <p class="mb-3">Trendjuwelier & conceptstore met hippe, betaalbare modeaccessoires. Waar elke vrouw zich op haar gemak voelt.</p>
                <div class="d-flex gap-2">
                    @if (!empty($organization['facebook_url']))
                        <a href="{{ $organization['facebook_url'] }}" class="social-icon" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if (!empty($organization['instagram_url']))
                        <a href="{{ $organization['instagram_url'] }}" class="social-icon" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <h5 class="font-display text-white">Snelle links</h5>
                <ul class="list-unstyled mb-0">
                    @foreach ($items as $item)
                        <li class="mb-2"><a href="{{ $item->resolvedUrl() }}" target="{{ $item->target }}">{{ $item->label }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="font-display text-white">Onze winkels</h5>
                @foreach ($stores as $store)
                    <div class="contact-line">
                        <i class="bi bi-geo-alt-fill"></i>
                        <a href="{{ route('store.show', $store->slug) }}">{{ $store->address_line }}, {{ $store->city }}</a>
                    </div>
                @endforeach
                @if ($stores->first()?->phone)
                    <div class="contact-line">
                        <i class="bi bi-telephone-fill"></i>
                        <span>{{ $stores->first()->phone }}</span>
                    </div>
                @endif
                @if (!empty($organization['email']))
                    <div class="contact-line">
                        <i class="bi bi-envelope-fill"></i>
                        <a href="mailto:{{ $organization['email'] }}">{{ $organization['email'] }}</a>
                    </div>
                @endif
            </div>
        </div>
        <hr class="my-4" style="border-color: rgba(255,255,255,.1)">
        <p class="mb-0 small text-center">&copy; {{ now()->year }} Nice2Have &nbsp;|&nbsp; Creatie &amp; design: <span class="credit">Worldwebdesign</span></p>
    </div>
</footer>
