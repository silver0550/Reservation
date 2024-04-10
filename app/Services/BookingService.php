<?php

namespace App\Services;

use App\Repositories\BookingRepository;

class BookingService
{

    public function __construct(private BookingRepository $bookingRepository)
    {
    }
}
