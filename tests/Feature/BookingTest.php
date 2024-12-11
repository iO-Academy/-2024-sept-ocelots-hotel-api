<?php

namespace Tests\Feature;

use App\Http\Controllers\RoomAPIController;
use App\Models\Booking;
use App\Models\HotelRoom;
use Database\Factories\HotelRoomFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use function PHPUnit\Framework\assertJson;

class BookingTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_GetBookings_success(): void
    {
        $booking = Booking::factory()->create();
        $booking->start='2080-12-31';
        $booking->end='2100-12-31';
        $booking->save();
//        HotelRoom::factory()->create();
        $response = $this->getJson('/api/bookings');
        $response->assertStatus(201)
        ->assertJson(function(AssertableJson $json) {
            $json->hasAll(['message', 'data'])
            ->has('data', 1, function(AssertableJson $data) {
                $data->hasAll(['id', 'customer', 'start', 'end', 'created_at', 'updated_at', 'room']);
            });
    });
    }

    public function test_getSingleBooking_success(): void
    {
        Booking::factory()->create();
        HotelRoom::factory()->create();

        $testData = [

        ]
    }
}
