<?php

namespace Tests\Feature;

use App\Models\HotelRoom;
use App\Models\Type;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use function PHPUnit\Framework\assertJson;

class HotelRoomTest extends TestCase
{
   use DatabaseMigrations;
    public function test_getRooms_success(): void
    {
        HotelRoom::factory()->create();
        Type::factory()->create();
        $response = $this->getJson('api/rooms');

        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message', 'data'])
                    ->has('data',1, function (AssertableJson $data) {
                        $data->hasAll(['id', 'name', 'image', 'min_capacity', 'max_capacity',
                            'type'])
                            ->whereAllType([
                            'id'=> 'integer', 'name'=>'string', 'image'=>'string', 'min_capacity' => 'integer', 'max_capacity'=>'integer']);
                    });
            });

    }
    public function test_getSingleRoom_success(): void
    {
        $room = HotelRoom::factory()->create();
        $response = $this->getJson("api/rooms/{$room->id}");
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) use ($room) {
                $json->hasAll(['message', 'data'])
                    ->has('data', function (AssertableJson $data) use ($room) {
                        $data->hasAll(['id', 'name', 'image', 'min_capacity', 'max_capacity', 'type'])
                        ->whereAllType([
                            'id'=> 'integer', 'name'=>'string', 'image'=>'string', 'min_capacity' => 'integer', 'max_capacity'=>'integer']);
                    });
            });
    }

    public function test_getSingleRoom_error(): void
    {
        $response = $this->getJson("api/rooms/2");
        $response->assertStatus(404)
        ->assertJson(function (AssertableJson $json) {
            $json->hasAll(['message']);
                });
    }


}