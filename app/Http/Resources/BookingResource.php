<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'day' => (int) $this->startOfReservation->format('d'),
            'time' => $this->startOfReservation->format('H:i'),
            'status' => $this->status->value,
        ];
    }
}
