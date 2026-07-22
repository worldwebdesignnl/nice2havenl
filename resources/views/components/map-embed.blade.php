@props(['store'])

@php
    $query = $store->google_maps_url
        ?: ($store->latitude && $store->longitude
            ? "{$store->latitude},{$store->longitude}"
            : "{$store->address_line}, {$store->postal_code} {$store->city}");

    $src = str_starts_with($query, 'http')
        ? $query
        : 'https://www.google.com/maps?q=' . urlencode($query) . '&output=embed';
@endphp

<div class="ratio ratio-16x9">
    <iframe src="{{ $src }}" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
