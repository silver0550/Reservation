<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->startOfReservation->format('Y-m-d'),
            'time' => $this->startOfReservation->format('H:i'),
        ];
    }
}
