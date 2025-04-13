<?php

namespace Database\Factories;

use App\Models\OrganizationMember;
use App\Models\OrganizationStructure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrganizationMember>
 */
class OrganizationMemberFactory extends Factory
{
    protected $model = OrganizationMember::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'position' => $this->faker->jobTitle,
            'image' => null, // À configurer manuellement
            'biography' => $this->faker->paragraphs(3, true),
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'social_media' => [
                'facebook' => 'https://facebook.com/' . $this->faker->userName,
                'twitter' => 'https://twitter.com/' . $this->faker->userName,
                'linkedin' => 'https://linkedin.com/in/' . $this->faker->userName,
            ],
            'order' => $this->faker->numberBetween(1, 100),
            'is_active' => true,
            'organization_structure_id' => OrganizationStructure::factory(),
        ];
    }
}
