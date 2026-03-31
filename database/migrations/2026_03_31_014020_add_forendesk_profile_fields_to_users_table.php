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
        Schema::table('users', function (Blueprint $table) {
            $table->ulid('ulid')->nullable()->unique()->after('id');
            $table->string('display_name')->nullable()->after('name');
            $table->string('job_title')->nullable()->after('display_name');
            $table->string('timezone', 100)->default('UTC')->after('job_title');
            $table->timestamp('last_seen_at')->nullable()->after('timezone');
            $table->foreignId('active_organization_id')->nullable()->after('last_seen_at')->constrained('organizations')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('active_organization_id');
            $table->dropColumn(['ulid', 'display_name', 'job_title', 'timezone', 'last_seen_at']);
        });
    }
};
