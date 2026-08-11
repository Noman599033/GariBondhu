<?php

namespace App\Services;

use App\Models\Car;
use App\Models\PricingRule;
use Carbon\Carbon;
use Exception;

class RentalPricingService
{
    /**
     * Calculate the base rental price based on global criteria-based pricing rules.
     * 
     * @param int $carId
     * @param Carbon|string $pickupAt
     * @param Carbon|string $scheduledReturnAt
     * @param Carbon|string|null $actualReturnAt
     * @return array
     * @throws Exception
     */
    public function calculatePricing(int $carId, $pickupAt, $scheduledReturnAt, $actualReturnAt = null): array
    {
        $car = Car::findOrFail($carId);
        $rule = PricingRule::findBestMatch($car);

        // Check if car has custom override
        $hasCustomOverride = !is_null($car->custom_daily_rate) || !is_null($car->custom_hourly_rate);

        if (!$hasCustomOverride && !$rule) {
            throw new Exception("No pricing rule configured for this car.");
        }

        $dailyRate = !is_null($car->custom_daily_rate) ? (float) $car->custom_daily_rate : ($rule ? (float) $rule->daily_rate : 0);
        $hourlyRate = !is_null($car->custom_hourly_rate) ? (float) $car->custom_hourly_rate : ($rule ? (float) $rule->hourly_rate : 0);
        
        // Default penalty to 2x hourly if not set anywhere
        $hourlyPenalty = !is_null($car->custom_hourly_penalty) 
            ? (float) $car->custom_hourly_penalty 
            : ($rule ? (float) $rule->hourly_penalty : $hourlyRate * 2);

        $pickup = Carbon::parse($pickupAt);
        $scheduled = Carbon::parse($scheduledReturnAt);
        
        // Calculate booked duration
        $totalMinutes = $pickup->diffInMinutes($scheduled);
        $totalHours = ceil($totalMinutes / 60);
        
        $bookedDays = floor($totalHours / 24);
        $bookedRemainingHours = $totalHours % 24;

        $baseRentAmount = ($bookedDays * $dailyRate) + ($bookedRemainingHours * $hourlyRate);

        $penaltyAmount = 0.0;
        $lateHours = 0;

        // If returned late, calculate penalty
        if ($actualReturnAt) {
            $actual = Carbon::parse($actualReturnAt);
            if ($actual->greaterThan($scheduled)) {
                $lateMinutes = $scheduled->diffInMinutes($actual);
                $lateHours = ceil($lateMinutes / 60);
                $penaltyAmount = $lateHours * $hourlyPenalty;
            }
        }

        $totalAmount = $baseRentAmount + $penaltyAmount;

        return [
            'pricing_rule_id' => $hasCustomOverride ? null : $rule->id,
            'is_custom_pricing' => $hasCustomOverride,
            'hourly_rate' => $hourlyRate,
            'daily_rate' => $dailyRate,
            'hourly_penalty_rate' => $hourlyPenalty,
            'booked_days' => $bookedDays,
            'booked_hours' => $bookedRemainingHours,
            'total_base_price' => round($baseRentAmount, 2),
            'late_hours' => $lateHours,
            'penalty_amount' => round($penaltyAmount, 2),
            'security_deposit' => $car->security_deposit_amount,
            'total_amount' => round($totalAmount + $car->security_deposit_amount, 2)
        ];
    }
}
