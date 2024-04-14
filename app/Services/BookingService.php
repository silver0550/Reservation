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

    public function getBookedTimes(int $year, int $month): Collection
    {
        return $this->bookingRepository->getBookedTimes($year, $month);
    }

    public function getMyAppointments(): Collection
    {
        return $this->bookingRepository->getMyAppointments();
    }

    public function store(array $data): void
    {
        $this->bookingRepository->create($data);
    }

    public function destroy(int $bookingId): void
    {
        $this->bookingRepository->delete($bookingId);
    }

    public function update(int $id, array $data): void
    {
        $this->bookingRepository->update($id, $data);
    }
}
