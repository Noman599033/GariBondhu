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
        Schema::table('cars', function (Blueprint $table) {
            $table->decimal('custom_daily_rate', 10, 2)->nullable()->after('status');
            $table->decimal('custom_hourly_rate', 10, 2)->nullable()->after('custom_daily_rate');
            $table->decimal('custom_hourly_penalty', 10, 2)->nullable()->after('custom_hourly_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['custom_daily_rate', 'custom_hourly_rate', 'custom_hourly_penalty']);
        });
    }
};
