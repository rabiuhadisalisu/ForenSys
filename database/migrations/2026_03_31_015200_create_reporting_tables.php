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
        Schema::create('forensic_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->foreignId('case_id')->constrained('cases')->restrictOnDelete();
            $table->ulid('ulid')->unique();
            $table->string('report_number');
            $table->string('title');
            $table->enum('status', ['draft', 'in_review', 'approved', 'published', 'archived'])->default('draft')->index();
            $table->string('template_key')->default('standard');
            $table->text('summary')->nullable();
            $table->string('pdf_disk')->nullable();
            $table->string('pdf_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'report_number']);
            $table->index(['case_id', 'status']);
        });

        Schema::create('report_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('forensic_reports')->cascadeOnDelete();
            $table->string('section_key');
            $table->string('title');
            $table->longText('content')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_included')->default(true);
            $table->string('source_type')->nullable();
            $table->timestamps();

            $table->unique(['report_id', 'section_key']);
            $table->index(['report_id', 'sort_order']);
        });

        Schema::create('report_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('forensic_reports')->cascadeOnDelete();
            $table->unsignedInteger('version_number');
            $table->json('snapshot_json');
            $table->text('change_summary')->nullable();
            $table->string('pdf_disk')->nullable();
            $table->string('pdf_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['report_id', 'version_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_versions');
        Schema::dropIfExists('report_sections');
        Schema::dropIfExists('forensic_reports');
    }
};
