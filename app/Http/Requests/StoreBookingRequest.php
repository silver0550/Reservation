<?php

namespace App\Http\Requests;

use App\Models\Booking;
use App\Rules\Weekday;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date:Y-m-d', 'after_or_equal:today', new Weekday()],
            'time' => ['required', Rule::in(Booking::VALID_TIMES)],
            //TODO: a dátum és az idő együtt nem szerepelhet az adatbázisban
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
