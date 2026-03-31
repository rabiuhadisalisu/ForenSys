<?php

namespace Database\Factories;

use App\Models\InvestigationCase;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<InvestigationCase>
 */
class InvestigationCaseFactory extends Factory
{
    protected $model = InvestigationCase::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'ulid' => (string) Str::ulid(),
            'case_number' => 'CASE-'.fake()->unique()->numerify('######'),
            'title' => fake()->sentence(4),
            'summary' => fake()->paragraph(),
            'status' => fake()->randomElement(['open', 'in_review', 'escalated']),
            'severity' => fake()->randomElement(['low', 'medium', 'high', 'critical']),
            'priority' => fake()->randomElement(['low', 'medium', 'high', 'urgent']),
            'classification' => fake()->randomElement(['training', 'internal', 'confidential']),
            'opened_at' => now()->subDays(fake()->numberBetween(1, 30)),
            'lead_analyst_id' => User::factory(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }
}
