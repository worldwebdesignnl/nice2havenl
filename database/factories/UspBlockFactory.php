<?php

namespace Database\Factories;

use App\Models\UspBlock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UspBlock>
 */
class UspBlockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'is_active' => true,
        ];
    }
}
