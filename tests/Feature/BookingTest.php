<?php

namespace Tests\Feature;

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
        Booking::factory()->create();
        HotelRoom::factory()->create();
        $response = $this->getJson('/api/bookings');
        $response->assertStatus(201)
        ->assertJson(function(AssertableJson $json) {
            $json->hasAll('message', 'data')
            ->has('data',  function(AssertableJson $data){
                $data->hasAll(['id', 'room_id', 'customer', 'start', 'end', 'created_at', 'updated_at', 'room']);
            });
    });
    }
}
