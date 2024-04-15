<?php

namespace App\Events;

use App\Enums\EventEnum;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingUpdateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private readonly int $month;
    public BookingResource $data;

    public function __construct(private readonly Booking $booking, public EventEnum $eventType)
    {
        $this->month = (int) $booking->startOfReservation->format('m');
        $this->data = new BookingResource($this->booking);
    }

    public function broadcastOn(): Channel
    {
        return new Channel('booking-update-'. $this->month);
    }
}
