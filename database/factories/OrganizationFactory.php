<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Organization>
 */
class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition(): array
    {
        $name = fake()->company().' Forensics Lab';

        return [
            'ulid' => (string) Str::ulid(),
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(100, 999),
            'code' => 'FD-'.Str::upper(Str::random(8)),
            'status' => fake()->randomElement(['active', 'active', 'active', 'suspended']),
            'settings_json' => [
                'workspace' => [
                    'theme' => 'forendesk-dark',
                ],
            ],
        ];
    }
}
