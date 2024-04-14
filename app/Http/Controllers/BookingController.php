<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

    public function create(Request $request): Response
    {
        $validated = $request->validate([
            'id' => [
                'required',
                Rule::exists('bookings', 'id')
                    ->where(function ($query) {
                        $query->where('user_id', userId());
                    })
            ],
        ]);

        return Inertia::render('Reservation/Create', [
            'booking' => new AppointmentResource($this->bookingService->getById($validated['id'])),
        ]);
    }

    public function reservation(): Response
    {
        return Inertia::render('Reservation/Reservation');
    }


    public function store(BookingRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $newBooking = $this->bookingService->store($validated);

        return response()->json($newBooking->id, ResponseCode::HTTP_CREATED);
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


        $bookings = $this->bookingService->getBookedTimes($validated['year'], $validated['month']);

        return response()->json(BookingResource::collection($bookings)->resolve(), ResponseCode::HTTP_OK);
    }

    public function getMyAppointments(): JsonResponse
    {
        $appointments = $this->bookingService->getMyAppointments();

        return response()->json(AppointmentResource::collection($appointments), ResponseCode::HTTP_OK);
    }

    public function status(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => [
                'required',
                Rule::exists('bookings', 'id')
                    ->where(function ($query) {
                        $query->where('user_id', userId());
                    })
            ],
            'status' => ['required', Rule::in(StatusEnum::getValues())],
        ]);

        $this->bookingService->setStatus($validated['id'], StatusEnum::from($validated['status']));

        return response()->json(null, ResponseCode::HTTP_OK);
    }
}
