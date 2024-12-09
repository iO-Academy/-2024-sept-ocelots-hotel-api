<?php

namespace App\Http\Controllers;

use App\Models\HotelRoom;
use Illuminate\Http\Request;

class RoomAPIController extends Controller
{
    public function index()
    {
        $rooms = HotelRoom::with('type')->all;

        return $rooms;
    }
public function single(int $id)
{
    $room = HotelRoom::with('type')->find($id);

    if (!$room) {
        return response()->json([
            'message' => "Room $id not found",
            'success' => false
        ],404);
    }
    else{
        return response()->json([
            'message' => 'Room found',
            'success' => true,
            'data' => $room
        ],200);
    }
}
}
