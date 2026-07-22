<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'location', 'parent_id', 'label', 'url',
        'linkable_type', 'linkable_id', 'target', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->where('is_active', true)->orderBy('sort_order');
    }

    public function linkable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', $location);
    }

    public function scopeTopLevel(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function resolvedUrl(): string
    {
        if ($this->linkable) {
            return match ($this->linkable_type) {
                Category::class => route('category.show', $this->linkable->slug),
                Brand::class => route('brand.show', $this->linkable->slug),
                Store::class => route('store.show', $this->linkable->slug),
                Page::class => route('page.show', $this->linkable->slug),
                default => $this->url ? url($this->url) : '#',
            };
        }

        return $this->url ? url($this->url) : '#';
    }

    public function isActive(): bool
    {
        $current = rtrim(request()->url(), '/') ?: '/';
        $target = rtrim($this->resolvedUrl(), '/') ?: '/';

        return $current === $target;
    }
}
