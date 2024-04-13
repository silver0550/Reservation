<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\BookingRequest;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;


class BookingController extends Controller
{
    public function __construct(private readonly BookingService $bookingService)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Reservation/Index');
    }

    public function create(): Response
    {
        return Inertia::render('Reservation/Create');
    }


    public function store(BookingRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->bookingService->store($validated);

        return response()->json(null, ResponseCode::HTTP_CREATED);
    }


    public function show(Booking $booking)
    {
        //
    }


    public function edit(Booking $booking)
    {
        //
    }


    public function update(BookingRequest $request, Booking $booking): JsonResponse
    {
        if ($booking->user_id == userId()) {
            $validated = $request->validated();
            $this->bookingService->update($booking->id, $validated);

            return response()->json(status: ResponseCode::HTTP_CREATED);
        }

        return response()->json(status: ResponseCode::HTTP_NOT_FOUND);
    }


    public function destroy(Booking $booking): JsonResponse
    {
        if ($booking->user_id == userId()) {
            $this->bookingService->destroy($booking->id);

            return response()->json(status: ResponseCode::HTTP_ACCEPTED);
        }

        return response()->json(status: ResponseCode::HTTP_NOT_FOUND);
    }

    public function getBookingTimes(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'year' => ['required', 'int', 'min:2024'],
            'month' => ['required', 'int', 'min:1', 'max:12'],
        ]);

        return response()->json(
            $this->bookingService->getBookedTimes($validated['year'], $validated['month']),
            ResponseCode::HTTP_OK
        );
    }

    public function getMyAppointments(): JsonResponse
    {
        return response()->json($this->bookingService->getMyAppointments(), ResponseCode::HTTP_OK);
    }
}
