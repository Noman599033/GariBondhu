<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class BookingService
{
    protected BookingAvailabilityService $availabilityService;
    protected RentalPricingService $pricingService;

    public function __construct(BookingAvailabilityService $availabilityService, RentalPricingService $pricingService)
    {
        $this->availabilityService = $availabilityService;
        $this->pricingService = $pricingService;
    }

    /**
     * Safely create a booking using pessimistic locking.
     * Ensures double-booking cannot occur.
     */
    public function createBooking(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Lock the car row to prevent concurrent bookings for the exact same car
            $car = Car::where('id', $data['car_id'])->lockForUpdate()->firstOrFail();

            // 2. Re-verify availability AFTER locking
            $isAvailable = $this->availabilityService->isCarAvailable(
                $car->id, 
                $data['pickup_at'], 
                $data['return_at']
            );

            if (!$isAvailable) {
                throw new Exception("The selected car is no longer available for the chosen dates.");
            }

            // 3. Re-calculate pricing on the server side
            $pricing = $this->pricingService->calculatePricing(
                $car->id, 
                $data['pickup_at'], 
                $data['return_at']
            );

            // 4. Create the Booking
            $booking = Booking::create([
                'booking_number' => 'BKG-' . strtoupper(uniqid()),
                'user_id' => $data['user_id'] ?? null,
                'car_id' => $car->id,
                'pickup_location_id' => $data['pickup_location_id'],
                'dropoff_location_id' => $data['dropoff_location_id'],
                'pickup_at' => $data['pickup_at'],
                'return_at' => $data['return_at'],
                'booking_status' => 'pending',
                'expires_at' => Carbon::now()->addMinutes(15), // Hold for 15 minutes
                'payment_status' => 'unpaid',
                'total_amount' => $pricing['total_base_price'], // Assuming no extras for now
                'security_deposit_amount' => $pricing['security_deposit'],
            ]);

            // 5. Create Booking Snapshot
            $booking->snapshot()->create([
                'car_name' => $car->name,
                'car_brand' => $car->brand->name ?? 'Unknown',
                'car_model' => $car->model,
                'car_registration_number' => $car->registration_number,
                'pickup_location_name' => 'Placeholder Location', // Would come from DB
                'dropoff_location_name' => 'Placeholder Location',
                'customer_name' => $data['customer_name'] ?? 'Guest',
                'customer_email' => $data['customer_email'] ?? null,
                'customer_phone' => $data['customer_phone'] ?? null,
                'currency' => 'BDT'
            ]);

            return $booking;
        });
    }
}
