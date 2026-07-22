<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpeningHour extends Model
{
    use HasFactory;

    protected $fillable = ['store_id', 'day_of_week', 'opens_at', 'closes_at', 'is_closed'];

    protected function casts(): array
    {
        return [
            'is_closed' => 'boolean',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function dayName(): string
    {
        return [
            0 => 'Maandag', 1 => 'Dinsdag', 2 => 'Woensdag', 3 => 'Donderdag',
            4 => 'Vrijdag', 5 => 'Zaterdag', 6 => 'Zondag',
        ][$this->day_of_week] ?? '';
    }
}
