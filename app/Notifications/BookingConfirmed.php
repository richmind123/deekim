<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Booking $booking,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Deekim booking is confirmed — ' . $this->booking->reference)
            ->greeting('Booking confirmed!')
            ->line('Your reservation at Deekim Hotel is confirmed.')
            ->line('Reference: ' . $this->booking->reference)
            ->line('Room type: ' . $this->booking->roomType->name)
            ->line('Check-in: ' . $this->booking->check_in->format('M j, Y'))
            ->line('Check-out: ' . $this->booking->check_out->format('M j, Y'))
            ->line('Total: $' . number_format($this->booking->total_price, 2))
            ->action('View Your Booking', route('bookings.index'))
            ->line('Thank you for choosing Deekim Hotel!');
    }
}