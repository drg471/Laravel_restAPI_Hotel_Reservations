<?php

namespace Tests\Feature\Reservation;

use App\Enums\Reservation\ReservationRoomType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ReservationUpdateRouteTest extends TestCase
{
    use Reservation_TestHelper;

    use RefreshDatabase;

    #[Test]
    public function it_updates_the_created_reservation()
    {
        Log::info("\n********\nRUN TEST => it_updates_the_created_reservation @ReservationUpdateRouteTest:\n********\n");

        $reservationId = $this->createTestReservation();

        $payload = [
            'id' => $reservationId,
            'guestName' => 'Sergio Updated',
            'checkInDate' => '2025-08-20',
            'roomType' => ReservationRoomType::suite->value,
        ];

        Log::info('$payload it_updates_the_created_reservation @ReservationUpdateRouteTest: ', $payload);

        $response = $this->putJson('api/reservations/update', $payload);

        Log::info('$response it_updates_the_created_reservation @ReservationUpdateRouteTest: ', [$response['data']]);

        $response->assertStatus(200)
            ->assertJsonFragment(['success' => true])
            ->assertJsonFragment(['guestName' => 'Sergio Updated']);
    }

    #[Test]
    public function it_fails_to_update_non_existing_reservation()
    {
        Log::info("\n********\nRUN TEST => it_fails_to_update_non_existing_reservation @ReservationUpdateRouteTest:\n********\n");

        $fakeId = Str::uuid()->toString();

        $this->createTestReservation();

        $payload = [
            'id' => $fakeId,
            'guestName' => 'Sergio Updated',
            'checkInDate' => '2025-08-20',
            'roomType' => ReservationRoomType::suite->value,
        ];

        $response = $this->putJson('api/reservations/update', $payload);

        $response->assertStatus(404);
    }

    #[Test]
    public function it_fails_with_invalid_id()
    {
        Log::info("\n********\nRUN TEST => it_fails_with_invalid_id @ReservationUpdateRouteTest:\n********\n");

        $invalidId = 12345;

        $this->createTestReservation();

        $payload = [
            'id' => $invalidId,
            'guestName' => 'Sergio Updated',
            'checkInDate' => '2025-08-20',
            'roomType' => ReservationRoomType::suite->value,
        ];

        $response = $this->putJson('api/reservations/update', $payload);

        $response->assertStatus(422);
    }
}
