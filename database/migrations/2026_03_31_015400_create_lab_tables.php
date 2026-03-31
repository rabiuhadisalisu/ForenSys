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
        Schema::create('lab_scenarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->ulid('ulid')->unique();
            $table->string('title');
            $table->string('slug');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->index();
            $table->enum('difficulty', ['intro', 'intermediate', 'advanced'])->default('intro')->index();
            $table->text('overview')->nullable();
            $table->longText('instructions')->nullable();
            $table->json('hints_json')->nullable();
            $table->json('answer_key_json')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'slug']);
        });

        Schema::create('lab_scenario_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_scenario_id')->constrained('lab_scenarios')->cascadeOnDelete();
            $table->string('title');
            $table->string('storage_disk')->default('local');
            $table->string('storage_path');
            $table->string('original_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size_bytes')->default(0);
            $table->string('hash_sha256', 64)->nullable()->index();
            $table->json('metadata_json')->nullable();
            $table->timestamps();
        });

        Schema::create('lab_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->foreignId('lab_scenario_id')->constrained('lab_scenarios')->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['assigned', 'in_progress', 'submitted', 'reviewed', 'closed'])->default('assigned')->index();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('due_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->decimal('max_score', 5, 2)->default(100);
            $table->decimal('score', 5, 2)->nullable();
            $table->timestamps();

            $table->unique(['organization_id', 'lab_scenario_id', 'user_id'], 'lab_assignments_org_scenario_user_unique');
        });

        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_assignment_id')->constrained('lab_assignments')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['draft', 'submitted', 'returned', 'graded'])->default('draft')->index();
            $table->json('submission_json')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('lab_assignments');
        Schema::dropIfExists('lab_scenario_assets');
        Schema::dropIfExists('lab_scenarios');
    }
};
