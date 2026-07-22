<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Store extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'name', 'slug', 'address_line', 'postal_code', 'city',
        'phone', 'email', 'shopping_center', 'description',
        'latitude', 'longitude', 'google_maps_url',
        'meta_title', 'meta_description', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
        $this->addMediaCollection('area_photo')->singleFile();
        $this->addMediaConversion('thumb')->width(400)->height(300);
        $this->addMediaConversion('medium')->width(900)->height(650);
    }

    public function openingHours(): HasMany
    {
        return $this->hasMany(OpeningHour::class)->orderBy('day_of_week');
    }

    public function contactSubmissions(): HasMany
    {
        return $this->hasMany(ContactSubmission::class);
    }

    public function photoUrl(string $conversion = 'medium'): ?string
    {
        $media = $this->getFirstMedia('photo');

        return $media?->getUrl($conversion) ?: $media?->getUrl();
    }

    public function areaPhotoUrl(): ?string
    {
        return $this->getFirstMediaUrl('area_photo') ?: null;
    }

    public function shoppingCenterShortName(): ?string
    {
        return $this->shopping_center
            ? trim(str_ireplace('winkelcentrum', '', $this->shopping_center))
            : null;
    }

    public function openingHoursSummary(): ?string
    {
        $days = ['ma', 'di', 'wo', 'do', 'vr', 'za', 'zo'];

        $open = $this->openingHours->reject(fn ($hour) => $hour->is_closed)->sortBy('day_of_week')->values();

        if ($open->isEmpty()) {
            return null;
        }

        $mostCommonOpensAt = $open->groupBy('opens_at')->sortByDesc(fn ($group) => $group->count())->keys()->first();

        $regularDays = $open->filter(fn ($hour) => $hour->opens_at === $mostCommonOpensAt);
        $summary = $days[$regularDays->first()->day_of_week].' t/m '.$days[$regularDays->last()->day_of_week].' geopend';

        foreach ($open->reject(fn ($hour) => $hour->opens_at === $mostCommonOpensAt) as $exception) {
            $summary .= ', '.$days[$exception->day_of_week].' vanaf '.substr($exception->opens_at, 0, 5);
        }

        return $summary;
    }

    public function openingHoursGrouped(): array
    {
        $dayNames = ['Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag'];

        $groups = [];

        foreach ($this->openingHours->sortBy('day_of_week') as $hour) {
            $key = $hour->is_closed ? 'closed' : $hour->opens_at.'-'.$hour->closes_at;
            $lastIndex = count($groups) - 1;

            if ($lastIndex >= 0 && $groups[$lastIndex]['key'] === $key) {
                $groups[$lastIndex]['days'][] = $hour->day_of_week;
            } else {
                $groups[] = ['key' => $key, 'days' => [$hour->day_of_week], 'hour' => $hour];
            }
        }

        return collect($groups)->map(function ($group) use ($dayNames) {
            $days = $group['days'];
            $label = count($days) > 1
                ? $dayNames[$days[0]].' t/m '.$dayNames[end($days)]
                : $dayNames[$days[0]];

            $hour = $group['hour'];
            $hoursText = $hour->is_closed
                ? 'Gesloten'
                : substr($hour->opens_at, 0, 5).' - '.substr($hour->closes_at, 0, 5);

            return ['label' => $label, 'hours' => $hoursText];
        })->all();
    }
}
