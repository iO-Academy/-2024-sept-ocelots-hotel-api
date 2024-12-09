<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingAPIController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('hotel_room')->get();

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
            'guests' => 'required|integer',
            'start' => 'required|date',
            'end' => 'required|date'
        ]);

        $booking = new Booking();
        $booking->room_id=$request->room_id;
        $booking->customer=$request->customer;
        $booking->guests=$request->guests;
        $booking->start=$request->start;
        $booking->end=$request->end;
        $booking->save();

        return response()->json([
            'message' => 'Booking successfully created',
            'data' => $booking,
        ], 201);
    }
}
