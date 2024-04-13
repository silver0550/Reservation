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
        $bookedTimes = $this->bookingRepository->getBookedTimes($year, $month);

        $formatted = [];

        foreach ($bookedTimes as $dateOfBooking) {
            $formatted [] = [
                'day' => (int) $dateOfBooking->format('d'),
                'time' => $dateOfBooking->format('H:i'),
            ];
        }

        return $formatted;
    }

    public function getMyAppointments(): array
    {
        $myAppointments = $this->bookingRepository->getMyAppointments();

        $formattedData = [];

        $myAppointments->each(function ($appointment) use (&$formattedData) {
            $formattedData [] = [
                'id' => $appointment->id,
                'date' => $appointment->startOfReservation->format('Y-m-d'),
                'time' => $appointment->startOfReservation->format('H:i')
            ];
        });

        return $formattedData;
    }

    public function store(array $data): void
    {
        $this->bookingRepository->create($data);
    }

    public function destroy(int $bookingId): void
    {
        $this->bookingRepository->delete($bookingId);
    }
}
