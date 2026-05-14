<?php

namespace App\Notifications;

use App\Models\RestaurantBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RestaurantBookingConfirmedNotification extends Notification
{
    use Queueable;

    public RestaurantBooking $booking;

    public function __construct(RestaurantBooking $booking)
    {
        $this->booking = $booking->loadMissing('items');
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $booking = $this->booking;

        return (new MailMessage)
            ->subject('Booking Confirmation - ' . ($booking->booking_code ?? 'Restaurant Booking'))
            ->view('emails.restaurant-booking-confirmed', [
                'booking' => $booking,
                'items' => $booking->items ?? collect(),
                'customerName' => $booking->customer_name ?? 'Customer',
                'bookingCode' => $booking->booking_code ?? 'N/A',
                'bookingType' => $booking->booking_type ?? 'buy_now',
                'paymentMethod' => $booking->payment_method ?? 'counter',
                'subtotal' => $booking->subtotal ?? 0,
                'total' => $booking->total ?? 0,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'booking_code' => $this->booking->booking_code,
            'customer_name' => $this->booking->customer_name,
            'email' => $this->booking->email,
            'booking_type' => $this->booking->booking_type,
            'total' => $this->booking->total,
        ];
    }
}