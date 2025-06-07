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
        Schema::create('project_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('talent_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('qc_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['project assign', 'draft', 'qc', 'revision', 'done']);
            $table->text('qc_message');
            $table->string('project_link');
            $table->timestamps();
            // Add indexes for better query performance
            $table->index(['user_id', 'company_id']);
            $table->index(['talent_id', 'qc_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_records');
    }
};
