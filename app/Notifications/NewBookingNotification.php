<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewBookingNotification extends Notification
{
    use Queueable;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
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
            'customer_name' => $this->booking->user->name ?? $this->booking->snapshot->customer_name ?? 'A customer',
            'message' => 'New booking placed: ' . $this->booking->booking_number,
            'url' => route('admin.bookings.show', $this->booking->id)
        ];
    }
}
