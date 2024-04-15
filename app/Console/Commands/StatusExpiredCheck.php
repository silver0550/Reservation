<?php

namespace App\Console\Commands;

use App\Enums\StatusEnum;
use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class StatusExpiredCheck extends Command
{
    protected $signature = 'status:check';

    protected $description = 'Management of stuck booking';

    public function handle(): int
    {
        $bookings = Booking::query()
            ->where('status', StatusEnum::PENDING)
            ->where('updated_at', '<=', now()->subMinute(5))
            ->get();

        $bookings->each(fn($booking) => $booking->update(['status' => StatusEnum::ABANDONED]));

        Log::info('Expired booking ids: ' . $bookings->pluck('id')->implode(', '));

        return self::SUCCESS;
    }
}
