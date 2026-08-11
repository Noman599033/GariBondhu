<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $bookings = Booking::with(['car', 'pickupLocation', 'dropoffLocation'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('customer.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // Ensure the user owns this booking
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->load(['car', 'pickupLocation', 'dropoffLocation', 'items', 'payments', 'snapshot']);
        
        return view('customer.bookings.show', compact('booking'));
    }

    public function storePayment(Request $request, Booking $booking)
    {
        // Ensure the user owns this booking
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:bkash,bank_transfer',
            'amount' => 'required|numeric|min:1',
            'transaction_id' => 'required|string|max:100',
        ]);

        $payment = $booking->payments()->create([
            'payment_method' => $validated['payment_method'],
            'amount' => $validated['amount'],
            'transaction_id' => $validated['transaction_id'],
            'status' => 'pending', // Pending verification by admin
            'type' => 'rental_payment',
            'currency' => 'BDT'
        ]);

        // Notify Admins
        $admins = \App\Models\Admin::all();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\NewPaymentNotification($booking, $payment));

        return redirect()->back()->with('success', 'Payment information submitted successfully. Our team will verify it shortly.');
    }
}
