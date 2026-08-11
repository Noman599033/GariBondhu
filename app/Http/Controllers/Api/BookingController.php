<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BookingAvailabilityService;
use App\Services\RentalPricingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $availabilityService;
    protected $pricingService;

    public function __construct(BookingAvailabilityService $availabilityService, RentalPricingService $pricingService)
    {
        $this->availabilityService = $availabilityService;
        $this->pricingService = $pricingService;
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'pickup_location_id' => 'required|exists:locations,id',
            'dropoff_location_id' => 'required|exists:locations,id',
            'pickup_at' => 'required',
            'return_at' => 'required',
        ]);

        $pickup = \Carbon\Carbon::parse($validated['pickup_at']);
        $return = \Carbon\Carbon::parse($validated['return_at']);

        if ($pickup->gte($return)) {
            return response()->json([
                'message' => 'The return time must be strictly after the pickup time.',
                'errors' => ['return_at' => ['The return time must be strictly after the pickup time.']]
            ], 422);
        }

        $availableCars = $this->availabilityService->getAvailableCars($validated['pickup_at'], $validated['return_at']);

        // Attach pricing context to each available car
        $carsWithPrices = $availableCars->map(function ($car) use ($validated) {
            try {
                $pricing = $this->pricingService->calculatePricing($car->id, $validated['pickup_at'], $validated['return_at']);
            } catch (\Exception $e) {
                // If no pricing rule is configured, we provide a default empty pricing array
                $pricing = [
                    'pricing_rule_id' => null,
                    'hourly_rate' => 0,
                    'daily_rate' => 0,
                    'hourly_penalty_rate' => 0,
                    'booked_days' => 0,
                    'booked_hours' => 0,
                    'total_base_price' => 0,
                    'late_hours' => 0,
                    'penalty_amount' => 0,
                    'security_deposit' => $car->security_deposit_amount ?? 0,
                    'total_amount' => 0
                ];
            }
            
            return [
                'id' => $car->id,
                'name' => $car->name,
                'model' => $car->model,
                'image' => $car->images->where('is_primary', true)->first()->image ?? null,
                'pricing' => $pricing
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $carsWithPrices
        ]);
    }
}
