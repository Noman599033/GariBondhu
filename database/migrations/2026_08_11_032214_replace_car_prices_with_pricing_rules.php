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
        // Drop the old car_prices table
        Schema::dropIfExists('car_prices');

        // Create the new pricing_rules table
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id();
            
            // Criteria for the rule
            $table->foreignId('category_id')->nullable()->constrained('car_categories')->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('car_brands')->nullOnDelete();
            $table->year('year')->nullable();
            $table->integer('seats')->nullable();
            
            // Rates setup
            $table->decimal('hourly_rate', 12, 2)->default(0);
            $table->decimal('daily_rate', 12, 2)->default(0);
            $table->decimal('hourly_penalty', 12, 2)->default(0);
            
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');

        Schema::create('car_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();
            $table->string('name');
            $table->enum('rate_type', ['daily', 'weekly', 'monthly', 'seasonal', 'weekend']);
            $table->decimal('amount', 12, 2);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('minimum_days')->default(1);
            $table->integer('maximum_days')->nullable();
            $table->integer('priority')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }
};
