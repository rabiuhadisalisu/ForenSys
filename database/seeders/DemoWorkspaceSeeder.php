<?php

namespace Database\Seeders;

use App\Models\AssignmentSubmission;
use App\Models\AuditLog;
use App\Models\CaseMember;
use App\Models\CaseNote;
use App\Models\CaseTimelineEvent;
use App\Models\CustodyLog;
use App\Models\EvidenceHash;
use App\Models\EvidenceItem;
use App\Models\EvidenceMetadata;
use App\Models\EvidenceNote;
use App\Models\ForensicReport;
use App\Models\InvestigationCase;
use App\Models\LabAssignment;
use App\Models\LabScenario;
use App\Models\LabScenarioAsset;
use App\Models\Label;
use App\Models\Organization;
use App\Models\ProcessingJob;
use App\Models\ReportSection;
use App\Models\ReportVersion;
use App\Models\SystemSetting;
use App\Models\ToolRun;
use App\Models\User;
use App\Models\WorkspaceNotification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoWorkspaceSeeder extends Seeder
{
    /**
     * Seed the forensic workspace with realistic demo records.
     */
    public function run(): void
    {
        $organization = Organization::factory()->create([
            'name' => 'ForenDesk Training Lab',
            'slug' => 'forendesk-training-lab',
            'code' => 'FD-DEMO-01',
            'status' => 'active',
        ]);

        $superAdmin = User::factory()->create([
            'name' => 'Avery Morgan',
            'display_name' => 'Avery Morgan',
            'email' => 'admin@forendesk.test',
            'job_title' => 'Super Admin',
            'timezone' => 'UTC',
            'password' => Hash::make('password'),
            'active_organization_id' => $organization->getKey(),
        ]);

        $instructor = User::factory()->create([
            'name' => 'Jordan Hale',
            'display_name' => 'Jordan Hale',
            'email' => 'instructor@forendesk.test',
            'job_title' => 'Instructor',
            'timezone' => 'UTC',
            'password' => Hash::make('password'),
            'active_organization_id' => $organization->getKey(),
        ]);

        $student = User::factory()->create([
            'name' => 'Riley Chen',
            'display_name' => 'Riley Chen',
            'email' => 'student@forendesk.test',
            'job_title' => 'Student Analyst',
            'timezone' => 'UTC',
            'password' => Hash::make('password'),
            'active_organization_id' => $organization->getKey(),
        ]);

        foreach ([$superAdmin, $instructor, $student] as $index => $user) {
            $user->organizations()->attach($organization->getKey(), [
                'membership_status' => 'active',
                'is_default' => $index === 0,
                'joined_at' => now()->subDays(14 - $index),
                'invited_by' => $superAdmin->getKey(),
            ]);
        }

        $case = InvestigationCase::factory()->create([
            'organization_id' => $organization->getKey(),
            'case_number' => 'CASE-2026-0001',
            'title' => 'Campus Device Metadata Review',
            'summary' => 'Review of user-owned files and captured lab logs for a defensive classroom exercise.',
            'status' => 'in_review',
            'severity' => 'medium',
            'priority' => 'high',
            'classification' => 'training',
            'lead_analyst_id' => $instructor->getKey(),
            'created_by' => $superAdmin->getKey(),
            'updated_by' => $instructor->getKey(),
            'opened_at' => now()->subDays(5),
        ]);

        CaseMember::query()->create([
            'case_id' => $case->getKey(),
            'user_id' => $instructor->getKey(),
            'member_role' => 'lead',
            'access_level' => 'manage',
            'assigned_by' => $superAdmin->getKey(),
            'assigned_at' => now()->subDays(5),
        ]);

        CaseMember::query()->create([
            'case_id' => $case->getKey(),
            'user_id' => $student->getKey(),
            'member_role' => 'student',
            'access_level' => 'contribute',
            'assigned_by' => $instructor->getKey(),
            'assigned_at' => now()->subDays(4),
        ]);

        CaseNote::query()->create([
            'organization_id' => $organization->getKey(),
            'case_id' => $case->getKey(),
            'user_id' => $instructor->getKey(),
            'note_type' => 'finding',
            'title' => 'Initial review scope',
            'content' => 'Student-owned source files and export logs were approved for analysis within the lab workflow.',
            'is_pinned' => true,
            'visibility' => 'case',
        ]);

        CaseTimelineEvent::query()->create([
            'organization_id' => $organization->getKey(),
            'case_id' => $case->getKey(),
            'actor_id' => $instructor->getKey(),
            'event_type' => 'case.opened',
            'title' => 'Case created',
            'description' => 'A new training scenario was opened for metadata review.',
            'event_at' => now()->subDays(5),
            'meta_json' => ['source' => 'manual'],
        ]);

        $label = Label::query()->create([
            'organization_id' => $organization->getKey(),
            'name' => 'Training',
            'slug' => 'training',
            'color' => 'cyan',
            'description' => 'Educational or instructor-led exercises.',
        ]);

        $case->labels()->attach($label->getKey());

        $evidence = EvidenceItem::factory()->create([
            'organization_id' => $organization->getKey(),
            'case_id' => $case->getKey(),
            'reference_id' => 'EVD-2026-0001',
            'display_name' => 'Browser Export Bundle',
            'original_name' => 'browser-export.json',
            'category' => 'archive',
            'acquisition_source' => 'student-upload',
            'source_reference' => 'LAB-UPLOAD-001',
            'storage_path' => 'evidence/demo/browser-export.json',
            'mime_type' => 'application/json',
            'extension' => 'json',
            'size_bytes' => 185024,
            'signature_status' => 'matched',
            'processing_status' => 'ready',
            'preview_status' => 'ready',
            'uploaded_by' => $student->getKey(),
        ]);

        $evidence->labels()->attach($label->getKey());

        EvidenceHash::query()->create([
            'evidence_item_id' => $evidence->getKey(),
            'algorithm' => 'sha256',
            'hash_value' => hash('sha256', 'browser-export.json'),
            'is_primary' => true,
            'computed_by' => $instructor->getKey(),
            'computed_at' => now()->subDays(4),
            'verified_at' => now()->subDays(4),
        ]);

        EvidenceMetadata::query()->create([
            'evidence_item_id' => $evidence->getKey(),
            'extractor' => 'safe-json-parser',
            'schema_version' => '1.0',
            'metadata_json' => [
                'format' => 'json',
                'charset' => 'utf-8',
                'records' => 148,
            ],
            'summary_json' => [
                'highlights' => ['Timestamps normalized', 'No unsupported preview actions required'],
            ],
            'extracted_at' => now()->subDays(4),
        ]);

        EvidenceNote::query()->create([
            'organization_id' => $organization->getKey(),
            'case_id' => $case->getKey(),
            'evidence_item_id' => $evidence->getKey(),
            'user_id' => $student->getKey(),
            'note_type' => 'analysis',
            'content' => 'Observed multiple ISO-8601 timestamps suitable for timeline reconstruction exercises.',
            'is_pinned' => true,
        ]);

        CustodyLog::query()->create([
            'organization_id' => $organization->getKey(),
            'case_id' => $case->getKey(),
            'evidence_item_id' => $evidence->getKey(),
            'recorded_by' => $instructor->getKey(),
            'action' => 'intake',
            'from_party' => 'Student Upload Portal',
            'to_party' => 'ForenDesk Evidence Locker',
            'location' => 'training-lab/vault-01',
            'notes' => 'Hash captured at intake.',
            'occurred_at' => now()->subDays(4),
        ]);

        $report = ForensicReport::factory()->create([
            'organization_id' => $organization->getKey(),
            'case_id' => $case->getKey(),
            'report_number' => 'RPT-2026-0001',
            'title' => 'Metadata Review Summary',
            'status' => 'draft',
            'summary' => 'Summary report for the classroom metadata analysis exercise.',
            'created_by' => $instructor->getKey(),
        ]);

        $report->labels()->attach($label->getKey());

        ReportSection::query()->create([
            'report_id' => $report->getKey(),
            'section_key' => 'summary',
            'title' => 'Summary',
            'content' => 'This report captures the evidence inventory, integrity data, and timeline-ready findings from the lab exercise.',
            'sort_order' => 1,
            'is_included' => true,
            'source_type' => 'manual',
        ]);

        ReportVersion::query()->create([
            'report_id' => $report->getKey(),
            'version_number' => 1,
            'snapshot_json' => [
                'title' => $report->title,
                'status' => $report->status,
            ],
            'change_summary' => 'Initial draft created from case notes and evidence metadata.',
            'created_by' => $instructor->getKey(),
        ]);

        ToolRun::query()->create([
            'organization_id' => $organization->getKey(),
            'case_id' => $case->getKey(),
            'evidence_item_id' => $evidence->getKey(),
            'user_id' => $student->getKey(),
            'tool_slug' => 'metadata-viewer',
            'tool_family' => 'evidence',
            'input_mode' => 'evidence',
            'status' => 'completed',
            'duration_ms' => 184,
            'input_summary_json' => ['reference_id' => $evidence->reference_id],
            'result_summary_json' => ['records' => 148],
            'ran_at' => now()->subDays(3),
        ]);

        AuditLog::query()->create([
            'organization_id' => $organization->getKey(),
            'user_id' => $student->getKey(),
            'action' => 'evidence.metadata.reviewed',
            'target_type' => EvidenceItem::class,
            'target_id' => $evidence->getKey(),
            'case_id' => $case->getKey(),
            'evidence_item_id' => $evidence->getKey(),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'ForenDesk Seeder',
            'severity' => 'info',
            'before_json' => null,
            'after_json' => ['status' => 'metadata-reviewed'],
            'context_json' => ['tool' => 'metadata-viewer'],
            'occurred_at' => now()->subDays(3),
        ]);

        $scenario = LabScenario::factory()->create([
            'organization_id' => $organization->getKey(),
            'title' => 'JSON Timeline Reconstruction',
            'slug' => 'json-timeline-reconstruction',
            'status' => 'published',
            'difficulty' => 'intro',
            'overview' => 'Students inspect exported browser data and reconstruct a basic event timeline.',
            'instructions' => 'Review the provided JSON evidence, verify its hash, and identify the earliest and latest captured timestamps.',
            'created_by' => $instructor->getKey(),
            'published_at' => now()->subDays(2),
        ]);

        LabScenarioAsset::query()->create([
            'lab_scenario_id' => $scenario->getKey(),
            'title' => 'Mock Browser Export',
            'storage_disk' => 'local',
            'storage_path' => 'labs/'.Str::uuid().'/browser-export.json',
            'original_name' => 'browser-export.json',
            'mime_type' => 'application/json',
            'size_bytes' => 185024,
            'hash_sha256' => hash('sha256', 'browser-export.json'),
            'metadata_json' => ['purpose' => 'timeline-practice'],
        ]);

        $assignment = LabAssignment::query()->create([
            'organization_id' => $organization->getKey(),
            'lab_scenario_id' => $scenario->getKey(),
            'user_id' => $student->getKey(),
            'assigned_by' => $instructor->getKey(),
            'status' => 'submitted',
            'assigned_at' => now()->subDays(2),
            'started_at' => now()->subDay(),
            'due_at' => now()->addDays(5),
            'completed_at' => now()->subHours(8),
            'max_score' => 100,
            'score' => 92,
        ]);

        AssignmentSubmission::query()->create([
            'lab_assignment_id' => $assignment->getKey(),
            'user_id' => $student->getKey(),
            'status' => 'submitted',
            'submission_json' => [
                'earliest_timestamp' => '2026-03-20T11:03:00Z',
                'latest_timestamp' => '2026-03-20T14:44:00Z',
            ],
            'notes' => 'Submitted after validating the sample hash and formatting the JSON artifact.',
            'score' => 92,
            'feedback' => 'Strong use of hash validation and clear reporting notes.',
            'reviewed_by' => $instructor->getKey(),
            'reviewed_at' => now()->subHours(4),
        ]);

        SystemSetting::query()->create([
            'organization_id' => $organization->getKey(),
            'scope_key' => 'org:'.$organization->getKey(),
            'group' => 'workspace',
            'key' => 'default_case_view',
            'value_json' => ['mode' => 'split-panel'],
            'value_type' => 'json',
            'is_public' => true,
        ]);

        ProcessingJob::query()->create([
            'organization_id' => $organization->getKey(),
            'user_id' => $student->getKey(),
            'case_id' => $case->getKey(),
            'evidence_item_id' => $evidence->getKey(),
            'job_type' => 'metadata_extract',
            'queue' => 'evidence',
            'status' => 'completed',
            'progress' => 100,
            'payload_summary_json' => ['reference_id' => $evidence->reference_id],
            'result_summary_json' => ['metadata_records' => 1],
            'started_at' => now()->subDays(4)->subMinutes(2),
            'finished_at' => now()->subDays(4),
        ]);

        WorkspaceNotification::query()->create([
            'organization_id' => $organization->getKey(),
            'user_id' => $student->getKey(),
            'case_id' => $case->getKey(),
            'type' => 'lab.feedback',
            'severity' => 'success',
            'title' => 'Instructor review completed',
            'body' => 'Your JSON Timeline Reconstruction submission has been reviewed.',
            'action_url' => route('labs.show', $scenario),
            'data_json' => ['assignment_id' => $assignment->getKey()],
            'read_at' => null,
        ]);
    }
}
