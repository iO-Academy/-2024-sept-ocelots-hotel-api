<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\HotelRoom;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     */
    public function test_get_bookings_success(): void
    {
        $booking = Booking::factory()->create();
        $booking->start = '2080-12-31';
        $booking->end = '2100-12-31';
        $booking->save();
        //        HotelRoom::factory()->create();
        $response = $this->getJson('/api/bookings');
        $response->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message', 'data'])
                    ->has('data', 1, function (AssertableJson $data) {
                        $data->hasAll(['id', 'customer', 'start', 'end', 'created_at', 'updated_at', 'room']);
                    });
            });
    }

    public function test_get_booking_by_room_success(): void
    {

        $booking = Booking::factory()->create();
        $secondBooking = Booking::factory()->create();
        $booking->start = '2080-12-31';
        $booking->end = '2100-12-31';
        $secondBooking->start = '2080-12-31';
        $secondBooking->end = '2100-12-31';
        $booking->save();
        $secondBooking->save();

        $response = $this->getJson('/api/bookings?room_id=1');
        $response->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message', 'data'])
                    ->has('data', 1, function (AssertableJson $data) {
                        $data->hasAll(['id', 'customer', 'start', 'end', 'created_at', 'updated_at', 'room']);
                    });
            });
    }

    public function test_create_booking_success(): void
    {
        HotelRoom::factory()->create();
        HotelRoom::factory()->create();

        $testData = [
            'room_id' => '2',
            'customer' => 'Dave',
            'guests' => '3',
            'start' => '2080-01-01',
            'end' => '2081-01-01',
        ];
        $response = $this->postJson('/api/bookings', $testData);
        $response->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message', 'data']);
            });
        $this->assertDatabaseHas('bookings', $testData);
    }
}
