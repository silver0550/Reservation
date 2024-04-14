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

    public function getBookedTimes(int $year, int $month, int $userId = null): Collection
    {
        return $this->model::query()
            ->when($userId, fn($query) => $query->where('user_id', $userId))
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where(function ($query) {
                $query->where('status', StatusEnum::RESOLVED)
                    ->orWhere('status', StatusEnum::PENDING);
            })->get();

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
