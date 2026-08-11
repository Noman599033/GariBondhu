<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['super_admin', 'manager', 'staff'])->default('staff');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('car_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('car_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('car_categories')->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('car_brands')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('model');
            $table->year('year');
            $table->string('registration_number');
            $table->enum('status', ['active', 'inactive', 'retired'])->default('active');
            $table->integer('seats')->default(4);
            $table->integer('doors')->default(4);
            $table->string('transmission');
            $table->string('fuel_type');
            $table->enum('mileage_type', ['unlimited', 'limited'])->default('unlimited');
            $table->integer('included_mileage')->nullable();
            $table->decimal('extra_mileage_rate', 12, 2)->nullable();
            $table->decimal('security_deposit_amount', 12, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

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

        Schema::create('car_features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('car_feature', function (Blueprint $table) {
            $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();
            $table->foreignId('feature_id')->constrained('car_features')->cascadeOnDelete();
            $table->primary(['car_id', 'feature_id']);
        });

        Schema::create('car_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();
            $table->string('image');
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('car_blockouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('reason');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('location_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pickup_location_id')->constrained('locations')->cascadeOnDelete();
            $table->foreignId('dropoff_location_id')->constrained('locations')->cascadeOnDelete();
            $table->decimal('fee_amount', 12, 2)->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('rental_options', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('pricing_type', ['per_day', 'fixed', 'per_rental']);
            $table->decimal('price', 12, 2);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->decimal('discount_value', 12, 2);
            $table->decimal('minimum_amount', 12, 2)->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); 
            $table->foreignId('car_id')->nullable()->constrained('cars')->nullOnDelete();
            $table->foreignId('pickup_location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('dropoff_location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->dateTime('pickup_at');
            $table->dateTime('return_at');
            $table->enum('booking_status', ['pending', 'confirmed', 'active', 'completed', 'cancelled', 'rejected', 'expired'])->default('pending');
            $table->dateTime('expires_at')->nullable();
            $table->enum('payment_status', ['unpaid', 'partial', 'paid', 'refunded'])->default('unpaid');
            $table->decimal('total_amount', 12, 2);
            $table->string('currency')->default('BDT');
            $table->decimal('security_deposit_amount', 12, 2)->default(0);
            $table->enum('security_deposit_status', ['pending', 'collected', 'released', 'retained'])->default('pending');
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('booking_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('type'); 
            $table->string('description');
            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('amount', 12, 2);
            $table->json('metadata')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('booking_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('car_name');
            $table->string('car_brand');
            $table->string('car_model');
            $table->string('car_registration_number');
            $table->string('pickup_location_name');
            $table->string('pickup_location_address')->nullable();
            $table->string('dropoff_location_name');
            $table->string('dropoff_location_address')->nullable();
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('currency');
            $table->timestamps();
        });

        Schema::create('booking_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('old_status')->nullable();
            $table->string('new_status');
            $table->nullableMorphs('changed_by');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('booking_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('type');
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->integer('quantity')->default(1);
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('booking_rental_option', function (Blueprint $table) {
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('rental_option_id')->nullable()->constrained('rental_options')->nullOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_price', 12, 2);
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('transaction_id')->nullable();
            $table->string('gateway_reference')->nullable();
            $table->string('payment_method');
            $table->decimal('amount', 12, 2);
            $table->string('currency')->default('BDT');
            $table->enum('type', ['rental_payment', 'deposit', 'refund', 'additional_charge']);
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->json('gateway_response')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('refunded_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('rental_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->enum('type', ['checkout', 'checkin']);
            $table->enum('inspection_status', ['pending', 'completed'])->default('pending');
            $table->string('mileage')->nullable();
            $table->string('fuel_level')->nullable();
            $table->text('damage_notes')->nullable();
            $table->text('accessories')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('inspected_by_admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('rental_inspection_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained('rental_inspections')->cascadeOnDelete();
            $table->enum('category', ['front', 'rear', 'left', 'right', 'interior', 'dashboard', 'damage', 'other']);
            $table->string('photo_path');
        });
    }

    public function down(): void {
        Schema::dropIfExists('rental_inspection_photos');
        Schema::dropIfExists('rental_inspections');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('booking_rental_option');
        Schema::dropIfExists('booking_charges');
        Schema::dropIfExists('booking_status_histories');
        Schema::dropIfExists('booking_snapshots');
        Schema::dropIfExists('booking_items');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('rental_options');
        Schema::dropIfExists('location_fees');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('car_blockouts');
        Schema::dropIfExists('car_images');
        Schema::dropIfExists('car_feature');
        Schema::dropIfExists('car_features');
        Schema::dropIfExists('car_prices');
        Schema::dropIfExists('cars');
        Schema::dropIfExists('car_brands');
        Schema::dropIfExists('car_categories');
        Schema::dropIfExists('admins');
    }
};
