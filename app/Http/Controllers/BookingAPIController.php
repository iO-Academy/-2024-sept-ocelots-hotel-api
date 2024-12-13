<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\HotelRoom;
use App\Services\BookingService;
use App\Services\DateService;
use Illuminate\Http\Request;

class BookingAPIController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['room_id' => 'nullable|exists:hotel_rooms,id']);

        $query = Booking::with('room:id,name')
            ->where('start', '>=', now())
            ->orderBy('start', 'asc');
        if ($request->has('room_id')) {
            $query = $query->where('room_id', '=', $request->room_id);
        }
        $bookings = $query->get()
            ->makeHidden(['guests', 'room_id']);

        return response()->json([
            'message' => 'Bookings successfully retrieved',
            'data' => $bookings,
        ], 201);
    }

    public function create(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:hotel_rooms,id',
            'customer' => 'required|string|max:255',
            'guests' => 'required|integer|min:1',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        if (DateService::isEndDateValid($request->start, $request->end) == false) {
            return response()->json([
                'message' => 'Start date must be before the end date',
            ], 400);
        }
        if (DateService::isDateInTheFuture($request->start) == false) {
            return response()->json([
                'message' => 'Start date must be in the future',
            ], 400);
        }
        $bookedRoom = HotelRoom::find($request->room_id);

        if (! BookingService::isRoomCapacityValid($bookedRoom, $request->guests)) {
            return response()->json([
                'message' => "The {$bookedRoom->name} room can only accommodate between {$bookedRoom->min_capacity} and {$bookedRoom->max_capacity} guests",
            ], 400);
        }

        $booking = new Booking;
        $booking->room_id = $request->room_id;
        $booking->customer = $request->customer;
        $booking->guests = $request->guests;
        $booking->start = $request->start;
        $booking->end = $request->end;

        $existingBookings = Booking::where('room_id', $request->room_id)->get();
        foreach ($existingBookings as $existingBooking) {
            if (! DateService::isDateAvailable($existingBooking, $booking)) {
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

    public function report()
    {
        $rooms = HotelRoom::with('booking')
            ->get();
        $reportData = [];

        foreach ($rooms as $room) {
            $bookingCount = 0;
            $bookingTotalDuration = 0;
            $bookingsInRoom = $room->Booking;
            $roomID = $room->id;
            $roomName = $room->name;

            if (!$room->bookings) $reportData[] = ([
                'id'=>$roomID,
                'name'=>$roomName,
                'booking_count'=>0,
                'average_booking_duration'=>0
            ]);

            foreach ($bookingsInRoom as $booking) {
                $bookingCount ++;
                $bookingDuration = (strtotime($booking->end)) - (strtotime($booking->start));
                $durationInDays = ((($bookingDuration / 60) / 60) / 24);
                $bookingTotalDuration += $bookingTotalDuration + $durationInDays;
            }
            if ($bookingCount) {
                $bookingAverageDuration = $bookingTotalDuration / $bookingCount;
            }

            if ($bookingCount == 0) {

                $reportData[] = [
                    'id' => $roomID,
                    'name' => $roomName,
                    'booking_count' => $bookingCount,
                    'average_booking_duration' => $bookingAverageDuration
                ];
            }
        }


        return response()->json([
            'message' => 'Report generated',
            'data' => $reportData
        ]);
    }

}
