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
            $table->string('gas_deployment_id')->nullable()->after('nda_agreed');
            $table->text('gas_hmac_key')->nullable()->after('gas_deployment_id');
            $table->string('gas_access_link')->nullable()->after('gas_hmac_key');
            $table->boolean('gas_api_enabled')->default(false)->after('gas_access_link');
            $table->timestamp('gas_last_test')->nullable()->after('gas_api_enabled');
            $table->text('gas_last_response')->nullable()->after('gas_last_test');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'gas_deployment_id',
                'gas_hmac_key',
                'gas_access_link',
                'gas_api_enabled',
                'gas_last_test',
                'gas_last_response'
            ]);
        });
    }
};
