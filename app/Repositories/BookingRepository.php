<?php

namespace App\Repositories;

use App\Models\Booking;

class BookingRepository extends BaseRepository
{

    protected function determineModelClass(): string
    {
        return Booking::class;
    }
}
