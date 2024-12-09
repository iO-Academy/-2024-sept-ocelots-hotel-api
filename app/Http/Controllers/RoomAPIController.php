<?php

namespace App\Http\Controllers;

use App\Models\HotelRoom;
use Illuminate\Http\Request;

class RoomAPIController extends Controller
{
    public function index()
    {
        $rooms = HotelRoom::all();

        return $rooms;
    }
}
