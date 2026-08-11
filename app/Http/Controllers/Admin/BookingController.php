<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['car', 'user', 'pickupLocation', 'dropoffLocation'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // Load relationships needed for the detailed view
        $booking->load(['car', 'user', 'pickupLocation', 'dropoffLocation', 'items', 'payments', 'snapshot']);
        
        return view('admin.bookings.show', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'booking_status' => 'required|in:pending,confirmed,active,completed,cancelled,rejected,expired',
            'payment_status' => 'required|in:unpaid,partial,paid,refunded',
            'payment_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|in:cash,card,bkash,bank_transfer'
        ]);

        $oldStatus = $booking->booking_status;

        // Process new payment if provided
        if (!empty($validated['payment_amount']) && $validated['payment_amount'] > 0) {
            $booking->payments()->create([
                'amount' => $validated['payment_amount'],
                'payment_method' => $validated['payment_method'] ?? 'cash',
                'currency' => 'BDT',
                'status' => 'completed',
                'type' => 'rental_payment'
            ]);

            // Auto-adjust payment status
            $totalPaid = $booking->payments()->where('status', 'completed')->sum('amount'); // This sum includes the newly created one
            $totalRequired = $booking->total_amount + $booking->security_deposit_amount;

            if ($totalPaid >= $totalRequired) {
                $validated['payment_status'] = 'paid';
            } elseif ($totalPaid > 0) {
                $validated['payment_status'] = 'partial';
            }
        }

        $booking->update([
            'booking_status' => $validated['booking_status'],
            'payment_status' => $validated['payment_status'],
        ]);
        
        if ($oldStatus !== $validated['booking_status']) {
            $booking->statusHistories()->create([
                'old_status' => $oldStatus,
                'new_status' => $validated['booking_status'],
                'changed_by_type' => \App\Models\Admin::class,
                'changed_by_id' => auth()->guard('admin')->id(),
                'note' => 'Status updated via Admin Panel'
            ]);

            // Notify Customer if registered
            if ($booking->user) {
                \Illuminate\Support\Facades\Notification::send($booking->user, new \App\Notifications\BookingStatusChangedNotification($booking));
            }
        }

        return redirect()->route('admin.bookings.show', $booking)->with('success', 'Booking updated successfully.');
    }

    public function updatePayment(Request $request, Booking $booking, \App\Models\Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:completed,failed'
        ]);

        // Ensure the payment belongs to this booking
        if ($payment->booking_id !== $booking->id) {
            abort(404);
        }

        $payment->update([
            'status' => $validated['status']
        ]);

        // Auto-adjust payment status (handles both upgrades and downgrades)
        $totalPaid = $booking->payments()->where('status', 'completed')->sum('amount');
        $totalRequired = $booking->total_amount + $booking->security_deposit_amount;

        $newPaymentStatus = $booking->payment_status;
        if ($totalPaid >= $totalRequired) {
            $newPaymentStatus = 'paid';
        } elseif ($totalPaid > 0) {
            $newPaymentStatus = 'partial';
        } else {
            $newPaymentStatus = 'unpaid';
        }

        if ($newPaymentStatus !== $booking->payment_status) {
            $booking->update(['payment_status' => $newPaymentStatus]);
        }

        return redirect()->back()->with('success', 'Payment status updated successfully.');
    }
}
