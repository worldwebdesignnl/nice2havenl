<?php

namespace App\Services;

use App\Models\SchemaSetting;
use App\Models\Store;

class SchemaService
{
    public function organization(): array
    {
        if (! SchemaSetting::get('schema_org_enabled', true)) {
            return [];
        }

        $organization = SchemaSetting::get('organization', []);

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => url('/').'#organization',
            'name' => $organization['name'] ?? config('app.name'),
            'url' => url('/'),
            'logo' => $organization['logo'] ?? null,
            'email' => $organization['email'] ?? null,
            'telephone' => $organization['phone'] ?? null,
            'sameAs' => array_values(array_filter([
                $organization['instagram_url'] ?? null,
                $organization['facebook_url'] ?? null,
            ])),
        ]);
    }

    public function localBusiness(Store $store): array
    {
        if (! SchemaSetting::get('schema_local_enabled', true)) {
            return [];
        }

        $openingHours = $store->openingHours
            ->reject(fn ($hour) => $hour->is_closed)
            ->map(fn ($hour) => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => $this->dayOfWeekSchema($hour->day_of_week),
                'opens' => $hour->opens_at,
                'closes' => $hour->closes_at,
            ])->values()->all();

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'JewelryStore',
            '@id' => route('store.show', $store->slug).'#store',
            'name' => 'Nice2Have '.$store->name,
            'parentOrganization' => ['@id' => url('/').'#organization'],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $store->address_line,
                'postalCode' => $store->postal_code,
                'addressLocality' => $store->city,
                'addressCountry' => 'NL',
            ],
            'telephone' => $store->phone,
            'email' => $store->email,
            'url' => route('store.show', $store->slug),
            'openingHoursSpecification' => $openingHours,
            'geo' => ($store->latitude && $store->longitude) ? [
                '@type' => 'GeoCoordinates',
                'latitude' => (float) $store->latitude,
                'longitude' => (float) $store->longitude,
            ] : null,
        ]);
    }

    public function breadcrumb(array $items): array
    {
        if (! SchemaSetting::get('schema_breadcrumb_enabled', true)) {
            return [];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn ($item, $index) => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ])->all(),
        ];
    }

    private function dayOfWeekSchema(int $dayOfWeek): string
    {
        return [
            0 => 'https://schema.org/Monday',
            1 => 'https://schema.org/Tuesday',
            2 => 'https://schema.org/Wednesday',
            3 => 'https://schema.org/Thursday',
            4 => 'https://schema.org/Friday',
            5 => 'https://schema.org/Saturday',
            6 => 'https://schema.org/Sunday',
        ][$dayOfWeek];
    }
}
