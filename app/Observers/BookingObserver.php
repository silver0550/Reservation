<?php

namespace App\Observers;

use App\Enums\EventEnum;
use App\Enums\StatusEnum;
use App\Events\BookingUpdateEvent;
use App\Models\Booking;

class BookingObserver
{
    public function creating(Booking $booking): void
    {
        if (is_null($booking->user_id)) {
            $booking->user_id = userId();
        }
    }

    public function created(Booking $booking): void
    {
        event(new BookingUpdateEvent($booking, EventEnum::CREATED));
    }

    public function updated(Booking $booking): void
    {
        $event= $booking->status === StatusEnum::RESOLVED
            ? EventEnum::UPDATED
            : EventEnum::DELETED;

        event(new BookingUpdateEvent($booking, $event));
    }

    public function deleted(Booking $booking): void
    {
        event(new BookingUpdateEvent($booking, EventEnum::DELETED));
    }
}
