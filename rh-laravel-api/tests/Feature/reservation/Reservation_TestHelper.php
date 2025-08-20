<?php

namespace Tests\Feature\Reservation;

use App\Enums\Reservation\ReservationRoomType;

trait Reservation_TestHelper
{
    protected function createTestReservation(): string
    {
        $payload = [
            'guestName' => 'Sergio Gómez',
            'guestEmail' => 'sgomez@example.com',
            'comments' => 'First reservation',
            'checkInDate' => '2025-08-20',
            'checkOutDate' => null,
            'roomType' => ReservationRoomType::family->value,
        ];

        $response = $this->postJson('api/reservations/new', $payload);
        $response->assertStatus(201);

        return $response->json()['data']; 
    }
}
