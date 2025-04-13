<?php

namespace Database\Factories;

use App\Models\OrganizationStructure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrganizationStructure>
 */
class OrganizationStructureFactory extends Factory
{
    protected $model = OrganizationStructure::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'image' => null,
            'role' => $this->faker->randomElement(['direction', 'service', 'département']),
            'group' => $this->faker->randomElement(['administration', 'technique', 'support']),
            'level' => $this->faker->numberBetween(1, 3),
            'parent_id' => null,
            'order' => $this->faker->numberBetween(1, 100),
            'is_active' => true,
        ];
    }
}
