<?php

namespace Database\Factories;

use App\Models\FlashInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlashInfoFactory extends Factory
{
    protected $model = FlashInfo::class;

    public function definition(): array
    {
        return [
            'message' => $this->faker->sentence(8),
            'is_active' => true,
            'start_date' => now()->subDays(rand(0, 5)),
            'end_date' => now()->addDays(rand(1, 10)),
            'display_order' => rand(1, 10),
            'display_mode' => $this->faker->randomElement(['static', 'scroll', 'fade']),
        ];
    }
}
