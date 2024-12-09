<?php

namespace App\Http\Controllers;

use App\Models\HotelRoom;

class RoomAPIController extends Controller
{
    public function index()
    {
        $rooms = HotelRoom::with('type')->get();

        return response()->json([
            'message' => 'Rooms successfully retrieved',
            'data' => $rooms,
        ], 200);
    }

    public function single(int $id)
    {
        $room = HotelRoom::with('type')->find($id);

        if (! $room) {
            return response()->json([
                'message' => "Room with id $id not found",
            ], 404);
        } else {
            return response()->json([
                'message' => 'Room successfully retrieved',
                'data' => $room,
            ], 200);
        }
    }
}
