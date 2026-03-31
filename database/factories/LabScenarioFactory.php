<?php

namespace Database\Factories;

use App\Models\LabScenario;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<LabScenario>
 */
class LabScenarioFactory extends Factory
{
    protected $model = LabScenario::class;

    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'organization_id' => Organization::factory(),
            'ulid' => (string) Str::ulid(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(100, 999),
            'status' => fake()->randomElement(['draft', 'published']),
            'difficulty' => fake()->randomElement(['intro', 'intermediate', 'advanced']),
            'overview' => fake()->paragraph(),
            'instructions' => fake()->paragraphs(3, true),
            'hints_json' => [fake()->sentence(), fake()->sentence()],
            'answer_key_json' => ['expected_findings' => [fake()->sentence(), fake()->sentence()]],
            'created_by' => User::factory(),
        ];
    }
}
