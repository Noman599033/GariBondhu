<?php

namespace App\Services;

use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BookingAvailabilityService
{
    /**
     * Check if a specific car is available for the given dates.
     *
     * @param int $carId
     * @param Carbon|string $pickupAt
     * @param Carbon|string $returnAt
     * @return bool
     */
    public function isCarAvailable(int $carId, $pickupAt, $returnAt): bool
    {
        $pickup = Carbon::parse($pickupAt);
        $return = Carbon::parse($returnAt);

        if ($pickup->gte($return)) {
            return false;
        }

        $car = Car::with(['blockouts', 'bookings' => function ($query) use ($pickup, $return) {
            $query->where(function ($q) use ($pickup, $return) {
                // Check for overlapping dates
                $q->whereBetween('pickup_at', [$pickup, $return])
                  ->orWhereBetween('return_at', [$pickup, $return])
                  ->orWhere(function ($q2) use ($pickup, $return) {
                      $q2->where('pickup_at', '<=', $pickup)
                         ->where('return_at', '>=', $return);
                  });
            });
        }])->find($carId);

        if (!$car || $car->status !== 'active') {
            return false;
        }

        // 1. Check Car Blockouts (Maintenance, etc.)
        foreach ($car->blockouts as $blockout) {
            if ($blockout->status === 'active') {
                $blockStart = Carbon::parse($blockout->start_datetime);
                $blockEnd = Carbon::parse($blockout->end_datetime);

                // If dates overlap
                if ($pickup->lt($blockEnd) && $return->gt($blockStart)) {
                    return false;
                }
            }
        }

        // 2. Check existing bookings
        foreach ($car->bookings as $booking) {
            // Completed, cancelled, rejected, expired do NOT block
            if (in_array($booking->booking_status, ['completed', 'cancelled', 'rejected', 'expired'])) {
                continue;
            }

            // Confirmed and Active ALWAYS block
            if (in_array($booking->booking_status, ['confirmed', 'active'])) {
                // If dates overlap
                if ($pickup->lt($booking->return_at) && $return->gt($booking->pickup_at)) {
                    return false;
                }
            }

            // Pending bookings block ONLY while expires_at > now()
            if ($booking->booking_status === 'pending') {
                if ($booking->expires_at && Carbon::parse($booking->expires_at)->gt(Carbon::now())) {
                    if ($pickup->lt($booking->return_at) && $return->gt($booking->pickup_at)) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Get a list of available cars for the given dates.
     */
    public function getAvailableCars($pickupAt, $returnAt): Collection
    {
        $pickup = Carbon::parse($pickupAt);
        $return = Carbon::parse($returnAt);
        
        // This is a naive implementation for small fleets.
        // For larger fleets, this logic should be pushed into a complex SQL query.
        $allCars = Car::where('status', 'active')->get();
        $availableCars = collect();

        foreach ($allCars as $car) {
            if ($this->isCarAvailable($car->id, $pickup, $return)) {
                $availableCars->push($car);
            }
        }

        return $availableCars;
    }
}
