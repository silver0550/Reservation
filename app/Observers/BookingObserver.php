<?php

namespace App\Observers;

use App\Models\Booking;

class BookingObserver
{
    public function creating(Booking $booking): void
    {
        if (is_null($booking->user_id)){
            $booking->user_id = userId();
        }
    }
}
