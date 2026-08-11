<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\CarCategory;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function search(Request $request)
    {
        $locations = Location::where('status', 'active')->get();
        $categories = CarCategory::where('status', 'active')->get();

        // Pass any pre-filled data from the home widget
        $initialParams = [
            'pickup_location_id' => $request->input('pickup_location_id', ''),
            'dropoff_location_id' => $request->input('dropoff_location_id', ''),
            'pickup_at' => $request->input('pickup_at', ''),
            'return_at' => $request->input('return_at', '')
        ];

        return view('public.search', compact('locations', 'categories', 'initialParams'));
    }

    public function checkout(Request $request)
    {
        $carId = $request->input('car_id');
        $pickupLoc = $request->input('pickup_location_id');
        $dropoffLoc = $request->input('dropoff_location_id');
        $pickupAt = $request->input('pickup_at');
        $returnAt = $request->input('return_at');

        if (!$carId || !$pickupLoc || !$dropoffLoc || !$pickupAt || !$returnAt) {
            return redirect()->route('search')->with('error', 'Incomplete booking details.');
        }

        $car = \App\Models\Car::with(['category', 'brand'])->findOrFail($carId);
        $pickupLocation = Location::findOrFail($pickupLoc);
        $dropoffLocation = Location::findOrFail($dropoffLoc);

        // Price Calculation
        $pricingService = new \App\Services\RentalPricingService();
        $pricing = $pricingService->calculatePricing($car->id, $pickupAt, $returnAt);

        return view('public.checkout', compact('car', 'pickupLocation', 'dropoffLocation', 'pickupAt', 'returnAt', 'pricing'));
    }

    public function storeCheckout(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'pickup_location_id' => 'required|exists:locations,id',
            'dropoff_location_id' => 'required|exists:locations,id',
            'pickup_at' => 'required',
            'return_at' => 'required',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        $pickup = \Carbon\Carbon::parse($validated['pickup_at']);
        $return = \Carbon\Carbon::parse($validated['return_at']);
        
        if ($pickup->gte($return)) {
            return back()->withInput()->with('error', 'The return time must be strictly after the pickup time.');
        }

        try {
            $bookingService = app(\App\Services\BookingService::class);
            
            // Note: Guest booking for now. If user is logged in, pass auth()->id()
            $userId = auth()->guard('web')->id() ?? null;

            $booking = $bookingService->createBooking([
                'car_id' => $validated['car_id'],
                'user_id' => $userId,
                'pickup_location_id' => $validated['pickup_location_id'],
                'dropoff_location_id' => $validated['dropoff_location_id'],
                'pickup_at' => $validated['pickup_at'],
                'return_at' => $validated['return_at'],
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone']
            ]);

            // Notify admins
            $admins = \App\Models\Admin::all();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\NewBookingNotification($booking));

            return redirect()->route('checkout.success', $booking->id);
            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function checkoutSuccess(\App\Models\Booking $booking)
    {
        $booking->load(['car', 'pickupLocation', 'dropoffLocation', 'snapshot']);
        return view('public.checkout-success', compact('booking'));
    }
}
