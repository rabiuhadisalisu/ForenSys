<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tool_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->foreignId('case_id')->nullable()->constrained('cases')->nullOnDelete();
            $table->foreignId('evidence_item_id')->nullable()->constrained('evidence_items')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('tool_slug');
            $table->string('tool_family');
            $table->string('input_mode')->default('manual');
            $table->enum('status', ['queued', 'running', 'completed', 'failed'])->default('completed')->index();
            $table->unsignedInteger('duration_ms')->nullable();
            $table->json('input_summary_json')->nullable();
            $table->json('result_summary_json')->nullable();
            $table->timestamp('ran_at')->index();
            $table->timestamps();

            $table->index(['organization_id', 'tool_slug']);
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');
            $table->string('target_type')->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
            $table->foreignId('case_id')->nullable()->constrained('cases')->nullOnDelete();
            $table->foreignId('evidence_item_id')->nullable()->constrained('evidence_items')->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->enum('severity', ['info', 'notice', 'warning', 'critical'])->default('info')->index();
            $table->json('before_json')->nullable();
            $table->json('after_json')->nullable();
            $table->json('context_json')->nullable();
            $table->timestamp('occurred_at')->index();
            $table->timestamps();

            $table->index(['organization_id', 'action', 'occurred_at']);
            $table->index(['organization_id', 'severity', 'occurred_at']);
        });

        Schema::create('workspace_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('case_id')->nullable()->constrained('cases')->nullOnDelete();
            $table->string('type');
            $table->enum('severity', ['info', 'success', 'warning', 'critical'])->default('info')->index();
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('action_url')->nullable();
            $table->json('data_json')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'read_at']);
            $table->index(['organization_id', 'type']);
        });

        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete();
            $table->string('scope_key')->default('global');
            $table->string('group');
            $table->string('key');
            $table->json('value_json')->nullable();
            $table->enum('value_type', ['string', 'integer', 'boolean', 'json', 'array'])->default('json');
            $table->boolean('is_public')->default(false);
            $table->timestamps();

            $table->unique(['scope_key', 'group', 'key']);
            $table->index(['organization_id', 'group']);
        });

        Schema::create('processing_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('case_id')->nullable()->constrained('cases')->nullOnDelete();
            $table->foreignId('evidence_item_id')->nullable()->constrained('evidence_items')->nullOnDelete();
            $table->string('job_type');
            $table->string('queue')->default('default');
            $table->enum('status', ['queued', 'processing', 'completed', 'failed', 'cancelled'])->default('queued')->index();
            $table->unsignedTinyInteger('progress')->default(0);
            $table->json('payload_summary_json')->nullable();
            $table->json('result_summary_json')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'status']);
            $table->index(['queue', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processing_jobs');
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('workspace_notifications');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('tool_runs');
    }
};
