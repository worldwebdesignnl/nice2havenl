<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'parent_id', 'name', 'slug', 'icon', 'description',
        'meta_title', 'meta_description', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
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
        $this->addMediaCollection('feature_photo')->singleFile();
        $this->addMediaCollection('gift_photo')->singleFile();
        $this->addMediaConversion('thumb')->width(500)->height(400);
        $this->addMediaConversion('medium')->width(1600)->height(700);
    }

    public function photoUrl(string $conversion = 'thumb'): ?string
    {
        $media = $this->getFirstMedia('photo');

        return $media?->getUrl($conversion) ?: $media?->getUrl();
    }

    public function featurePhotoUrl(): ?string
    {
        return $this->getFirstMediaUrl('feature_photo') ?: null;
    }

    public function giftPhotoUrl(): ?string
    {
        return $this->getFirstMediaUrl('gift_photo') ?: null;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function faqs(): MorphMany
    {
        return $this->morphMany(Faq::class, 'faqable');
    }

    public function scopeTopLevel(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
