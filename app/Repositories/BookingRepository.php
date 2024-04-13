<?php

namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class BookingRepository extends BaseRepository
{

    protected function determineModelClass(): string
    {
        return Booking::class;
    }

    public function getBookedTimes(int $year, int $month, int $userId = null): array
    {
        return $this->model::query()
            ->when($userId, fn($query) => $query->where('user_id', $userId))
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where('status', StatusEnum::RESOLVED)
            ->get()
            ->pluck('startOfReservation')
            ->toArray();
    }

    public function getMyAppointments(): Collection
    {
        return $this->model::query()
            ->where('user_id', userId())
            ->where('status', StatusEnum::RESOLVED)
            ->orderBy('date')
            ->orderBy('time')
            ->get();

    }
}
