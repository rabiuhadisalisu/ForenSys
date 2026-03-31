<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForenDeskWorkspaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_center_requires_an_active_organization_membership(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user)
            ->get(route('command-center'))
            ->assertForbidden();
    }

    public function test_command_center_renders_for_a_verified_org_member(): void
    {
        $organization = Organization::factory()->create([
            'name' => 'Evidence Lab',
        ]);

        $user = User::factory()->create([
            'email_verified_at' => now(),
            'active_organization_id' => $organization->getKey(),
        ]);

        $user->organizations()->attach($organization->getKey(), [
            'membership_status' => 'active',
            'is_default' => true,
            'joined_at' => now(),
            'invited_by' => $user->getKey(),
        ]);

        $this->actingAs($user)
            ->get(route('command-center'))
            ->assertOk()
            ->assertSee('ForenDesk Command Center')
            ->assertSee('Evidence Lab');
    }

    public function test_internal_command_center_api_uses_the_standard_json_envelope(): void
    {
        $organization = Organization::factory()->create();

        $user = User::factory()->create([
            'email_verified_at' => now(),
            'active_organization_id' => $organization->getKey(),
        ]);

        $user->organizations()->attach($organization->getKey(), [
            'membership_status' => 'active',
            'is_default' => true,
            'joined_at' => now(),
            'invited_by' => $user->getKey(),
        ]);

        $this->actingAs($user)
            ->getJson(route('api.command-center.show'))
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'stats',
                    'recent_cases',
                    'recent_evidence',
                    'recent_activity',
                    'featured_tools',
                ],
                'errors',
            ]);
    }
}
