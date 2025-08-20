<?php

namespace Tests\Feature\Reservation;

use App\Enums\Reservation\ReservationRoomType;
use App\Storage\Reservation\ReservationStorage;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ReservationCreateRouteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ReservationStorage::clear();
    }

    #[Test]
    public function it_creates_a_reservation()
    {
        Log::info("\n********\nRUN TEST => it_creates_a_reservation @ReservationRoutesTest:\n********\n");

        $payload = [
            'guestName' => 'Sergio Gómez',
            'guestEmail' => 'sgomez@example.com',
            'comments' => 'First reservation',
            'checkInDate' => '2025-08-20',
            'checkOutDate' => null,
            'roomType' => ReservationRoomType::family->value,
        ];

        $response = $this->postJson('api/reservations/new', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);

        $reservationId = $response->json()['data'];

        $this->assertArrayHasKey($reservationId, ReservationStorage::all());
    }

    #[Test]
    public function it_fails_to_create_a_reservation_with_invalid_data()
    {
        Log::info("\n********\nRUN TEST => it_fails_to_create_a_reservation_with_invalid_data @ReservationRoutesTest:\n********\n");

        $payload = [
            'guestName' => '',
            'guestEmail' => 'sgomez@example.com',
            'comments' => 'First reservation',
            'checkInDate' => '2025-08-20',
            'checkOutDate' => null,
            'roomType' => ReservationRoomType::family->value,
        ];

        $response = $this->postJson('api/reservations/new', $payload);

        $response->assertStatus(422);
    }
}
