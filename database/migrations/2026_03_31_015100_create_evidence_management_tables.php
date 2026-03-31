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
        Schema::create('evidence_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->foreignId('case_id')->constrained('cases')->restrictOnDelete();
            $table->ulid('ulid')->unique();
            $table->string('reference_id');
            $table->string('display_name');
            $table->string('original_name');
            $table->enum('category', ['disk_image', 'document', 'media', 'archive', 'log', 'memory_dump', 'network_capture', 'other'])->default('other');
            $table->string('acquisition_source')->nullable();
            $table->string('source_reference')->nullable();
            $table->string('storage_disk')->default('local');
            $table->string('storage_path');
            $table->string('mime_type')->nullable();
            $table->string('extension', 32)->nullable();
            $table->unsignedBigInteger('size_bytes')->default(0);
            $table->enum('signature_status', ['pending', 'matched', 'mismatch', 'unknown'])->default('pending')->index();
            $table->enum('processing_status', ['queued', 'processing', 'ready', 'failed'])->default('queued')->index();
            $table->enum('preview_status', ['unavailable', 'pending', 'ready', 'restricted'])->default('unavailable')->index();
            $table->boolean('is_quarantined')->default(false)->index();
            $table->timestamp('quarantined_at')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'reference_id']);
            $table->index(['case_id', 'processing_status']);
        });

        Schema::create('evidence_hashes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evidence_item_id')->constrained('evidence_items')->cascadeOnDelete();
            $table->string('algorithm', 32);
            $table->string('hash_value', 128)->index();
            $table->boolean('is_primary')->default(false);
            $table->foreignId('computed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('computed_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->unique(['evidence_item_id', 'algorithm']);
        });

        Schema::create('evidence_metadata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evidence_item_id')->constrained('evidence_items')->cascadeOnDelete();
            $table->string('extractor');
            $table->string('schema_version', 32)->default('1.0');
            $table->json('metadata_json');
            $table->json('summary_json')->nullable();
            $table->timestamp('extracted_at')->nullable();
            $table->timestamps();

            $table->index(['evidence_item_id', 'extractor']);
        });

        Schema::create('evidence_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->foreignId('case_id')->constrained('cases')->restrictOnDelete();
            $table->foreignId('evidence_item_id')->constrained('evidence_items')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('note_type', ['analysis', 'finding', 'chain_of_custody', 'review'])->default('analysis');
            $table->longText('content');
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();

            $table->index(['evidence_item_id', 'note_type']);
        });

        Schema::create('custody_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->foreignId('case_id')->constrained('cases')->restrictOnDelete();
            $table->foreignId('evidence_item_id')->constrained('evidence_items')->cascadeOnDelete();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('action', ['intake', 'transfer', 'review', 'verification', 'storage', 'release'])->default('intake');
            $table->string('from_party')->nullable();
            $table->string('to_party')->nullable();
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('occurred_at')->index();
            $table->timestamps();

            $table->index(['evidence_item_id', 'occurred_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custody_logs');
        Schema::dropIfExists('evidence_notes');
        Schema::dropIfExists('evidence_metadata');
        Schema::dropIfExists('evidence_hashes');
        Schema::dropIfExists('evidence_items');
    }
};
