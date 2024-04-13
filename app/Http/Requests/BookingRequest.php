<?php

namespace App\Http\Requests;

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
                    ->where(fn($query) => $query->where('date', $this->date)->where('time', $this->time))
            ],
        ];
    }

    public function Attribute(): array
    {
        return [
            'date' => __('booking.date'),
            'time' => __('booking.time'),
        ];
    }
}
