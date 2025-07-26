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
        Schema::create('project_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('project_type');
            $table->string('project_title');
            $table->string('project_code')->nullable();
            $table->text('project_link')->nullable();
            $table->enum('role', ['talent', 'talent_qc']);
            $table->enum('status', ['active', 'completed'])->default('active');
            $table->timestamp('start_at');
            $table->timestamp('end_at')->nullable();
            $table->integer('working_duration')->default(0); // in seconds
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_tracking');
    }
};
