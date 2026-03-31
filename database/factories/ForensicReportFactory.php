<?php

namespace Database\Factories;

use App\Models\ForensicReport;
use App\Models\InvestigationCase;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ForensicReport>
 */
class ForensicReportFactory extends Factory
{
    protected $model = ForensicReport::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'case_id' => InvestigationCase::factory(),
            'ulid' => (string) Str::ulid(),
            'report_number' => 'RPT-'.fake()->unique()->numerify('######'),
            'title' => fake()->sentence(5),
            'status' => fake()->randomElement(['draft', 'in_review', 'approved']),
            'template_key' => 'standard',
            'summary' => fake()->paragraph(),
            'created_by' => User::factory(),
            'approved_by' => User::factory(),
        ];
    }
}
