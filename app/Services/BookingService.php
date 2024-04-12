<?php

namespace App\Services;

use App\Models\Booking;
use App\Repositories\BookingRepository;
use Illuminate\Database\Eloquent\Collection;

class BookingService
{

    public function __construct(private readonly BookingRepository $bookingRepository)
    {
    }

    public function getBookedTimes(int $year, int $month): array
    {
        $bookings = $this->bookingRepository->getBookedTimes($year, $month);

        $formatted = [];

        foreach ($bookings as $booking) {
            $formatted [] = [
                'day' => (int) $booking->format('d'),
                'time' => $booking->format('H:i'),
            ];
        }

        return $formatted;
    }
}
