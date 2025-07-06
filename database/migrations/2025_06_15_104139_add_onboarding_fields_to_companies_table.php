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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('registration_number')->nullable();
            $table->string('address')->nullable();
            $table->string('business_license_path')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('invoice_recipient')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('payment_schedule')->nullable();
            $table->string('currency')->nullable();
            $table->string('primary_use_case')->nullable();
            $table->boolean('nda_agreed')->default(false);
            $table->json('collaboration_tools')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'registration_number',
                'address',
                'business_license_path',
                'billing_address',
                'billing_email',
                'invoice_recipient',
                'zip_code',
                'tax_id',
                'payment_schedule',
                'currency',
                'primary_use_case',
                'nda_agreed',
                'collaboration_tools',
            ]);
        });
    }
};
