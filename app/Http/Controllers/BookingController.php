<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Services\BookingService;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    public function __construct(private readonly BookingService $bookingService)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Reservation/Index', [
            'bookedTimes' => $this->bookingService->getBookedTimes(now()->year, now()->month)
        ]);
    }

    public function create()
    {
        //
    }


    public function store(StoreBookingRequest $request)
    {
        //
    }


    public function show(Booking $booking)
    {
        //
    }


    public function edit(Booking $booking)
    {
        //
    }


    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        //
    }


    public function destroy(Booking $booking)
    {
        //
    }
}
