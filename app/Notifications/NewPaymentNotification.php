<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewPaymentNotification extends Notification
{
    use Queueable;

    public $booking;
    public $payment;

    public function __construct(Booking $booking, Payment $payment)
    {
        $this->booking = $booking;
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'payment_id' => $this->payment->id,
            'amount' => $this->payment->amount,
            'customer_name' => $this->booking->user->name ?? $this->booking->snapshot->customer_name ?? 'A customer',
            'message' => 'New payment of ৳' . number_format($this->payment->amount, 2) . ' received for booking ' . $this->booking->booking_number,
            'url' => route('admin.bookings.show', $this->booking->id)
        ];
    }
}
