<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemaSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'is_active'];

    protected function casts(): array
    {
        return [
            'value' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return static::query()->where('key', $key)->where('is_active', true)->value('value') ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value, 'is_active' => true]);
    }
}
