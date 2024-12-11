<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\DateService;
use Illuminate\Http\Request;

class BookingAPIController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('room:id,name')
            ->where('start', '>=', now())
            ->orderBy('start', 'asc')
            ->get()
            ->makeHidden(['guests', 'room_id']);

        return response()->json([
            'message' => 'Rooms successfully retrieved',
            'data' => $bookings,
        ], 201);
    }

    public function create(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:hotel_rooms,id',
            'customer' => 'required|string|max:255',
            'guests' => 'required|integer|min:1',
            'start' => 'required|date|',
            'end' => 'required|date',
        ]);

        $booking = new Booking;
        $booking->room_id = $request->room_id;
        $booking->customer = $request->customer;
        $booking->guests = $request->guests;
        $booking->start = $request->start;
        $booking->end = $request->end;
        if (DateService::futureDate($booking->start) == false) {
            return response()->json([
                'message' => 'Start date must be in the future',
            ], 400);
        }

        if (DateService::validEndDate($booking->start, $booking->end) == false) {
            return response()->json([
                'message' => 'Start date must be before the end date',
            ], 400);
        }

        $existingBookings = Booking::where('room_id', $booking->room_id)->get();
        foreach ($existingBookings as $existingBooking) {
            if (DateService::availableDate($existingBooking, $booking) == false) {
                return response()->json([
                    'message' => 'Room unavailable for the chosen dates',
                ], 400);
            }
        }
        $booking->save();

        return response()->json([
            'message' => 'Booking successfully created',
            'data' => $booking,
        ], 201);
    }
}
