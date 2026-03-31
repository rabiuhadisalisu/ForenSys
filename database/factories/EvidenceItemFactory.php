<?php

namespace Database\Factories;

use App\Models\EvidenceItem;
use App\Models\InvestigationCase;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<EvidenceItem>
 */
class EvidenceItemFactory extends Factory
{
    protected $model = EvidenceItem::class;

    public function definition(): array
    {
        $fileName = Str::slug(fake()->words(3, true)).'.txt';

        return [
            'organization_id' => Organization::factory(),
            'case_id' => InvestigationCase::factory(),
            'ulid' => (string) Str::ulid(),
            'reference_id' => 'EVD-'.fake()->unique()->numerify('######'),
            'display_name' => fake()->sentence(3),
            'original_name' => $fileName,
            'category' => fake()->randomElement(['document', 'archive', 'log', 'media', 'other']),
            'acquisition_source' => fake()->randomElement(['student-upload', 'lab-import', 'owned-media']),
            'source_reference' => fake()->uuid(),
            'storage_disk' => 'local',
            'storage_path' => 'evidence/'.fake()->uuid().'/'.$fileName,
            'mime_type' => 'text/plain',
            'extension' => 'txt',
            'size_bytes' => fake()->numberBetween(512, 5000000),
            'signature_status' => fake()->randomElement(['matched', 'pending', 'unknown']),
            'processing_status' => fake()->randomElement(['queued', 'processing', 'ready']),
            'preview_status' => fake()->randomElement(['pending', 'ready', 'restricted']),
            'is_quarantined' => false,
            'uploaded_by' => User::factory(),
        ];
    }
}
