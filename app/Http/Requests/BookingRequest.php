<?php

namespace App\Http\Requests;

use App\Enums\StatusEnum;
use App\Models\Booking;
use App\Rules\Weekday;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return !is_null(user());
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date:Y-m-d', 'after_or_equal:today', new Weekday()],
            'time' => [
                'required',
                Rule::in(Booking::VALID_TIMES),
                Rule::unique('bookings')
                    ->where(function ($query) {
                        return $query->where('date', $this->date)
                            ->where('time', $this->time)
                            ->whereNull('deleted_at')
                            ->where(function ($query) {
                                $query->where('status', StatusEnum::RESOLVED)
                                    ->orWhere('status', StatusEnum::PENDING);
                            });
                    })
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'date' => __('booking.date'),
            'time' => __('booking.time'),
        ];
    }
}
