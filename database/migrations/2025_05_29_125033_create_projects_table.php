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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('project_name');
            $table->string('project_volume');
            $table->string('project_file')->nullable();
            $table->foreignId('project_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('talent')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('qc_agent')->nullable()->constrained('users')->onDelete('cascade');
            $table->decimal('project_rate', 10, 2);
            $table->decimal('qc_rate', 10, 2);
            $table->decimal('bonuses', 10, 2)->default(0);
            $table->string('status')->default('waiting talent');
            $table->date('start_date');
            $table->date('finish_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
