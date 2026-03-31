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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->ulid('ulid')->unique();
            $table->string('case_number');
            $table->string('title');
            $table->text('summary')->nullable();
            $table->enum('status', ['open', 'in_review', 'escalated', 'closed', 'archived'])->default('open')->index();
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium')->index();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->index();
            $table->enum('classification', ['training', 'internal', 'confidential', 'restricted'])->default('internal');
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->foreignId('lead_analyst_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'case_number']);
            $table->index(['organization_id', 'status', 'severity', 'priority'], 'cases_org_status_severity_priority_index');
        });

        Schema::create('case_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('cases')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('member_role', ['lead', 'analyst', 'reviewer', 'student', 'observer'])->default('analyst');
            $table->enum('access_level', ['read', 'contribute', 'manage'])->default('read');
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamps();

            $table->unique(['case_id', 'user_id']);
            $table->index(['user_id', 'member_role']);
        });

        Schema::create('case_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->foreignId('case_id')->constrained('cases')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('note_type', ['finding', 'comment', 'instruction', 'observation'])->default('observation');
            $table->string('title')->nullable();
            $table->longText('content');
            $table->boolean('is_pinned')->default(false);
            $table->enum('visibility', ['private', 'case', 'instructor'])->default('case');
            $table->timestamps();

            $table->index(['case_id', 'note_type', 'visibility']);
        });

        Schema::create('case_timeline_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->foreignId('case_id')->constrained('cases')->cascadeOnDelete();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('event_type')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('event_at')->index();
            $table->json('meta_json')->nullable();
            $table->timestamps();

            $table->index(['case_id', 'event_at']);
        });

        Schema::create('labels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('color', 32)->default('slate');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['organization_id', 'slug']);
        });

        Schema::create('labelables', function (Blueprint $table) {
            $table->foreignId('label_id')->constrained('labels')->cascadeOnDelete();
            $table->string('labelable_type');
            $table->unsignedBigInteger('labelable_id');
            $table->timestamps();

            $table->primary(['label_id', 'labelable_type', 'labelable_id']);
            $table->index(['labelable_type', 'labelable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labelables');
        Schema::dropIfExists('labels');
        Schema::dropIfExists('case_timeline_events');
        Schema::dropIfExists('case_notes');
        Schema::dropIfExists('case_members');
        Schema::dropIfExists('cases');
    }
};
