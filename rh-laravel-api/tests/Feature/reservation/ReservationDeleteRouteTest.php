<?php

namespace Tests\Feature\Reservation;

use App\Storage\Reservation\ReservationStorage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ReservationDeleteRouteTest extends TestCase
{
    use Reservation_TestHelper;

    protected function setUp(): void
    {
        parent::setUp();
        ReservationStorage::clear();
    }

    #[Test]
    public function it_deletes_a_reservation()
    {
        Log::info("\n********\nRUN TEST => it_deletes_a_reservation @ReservationDeleteRouteTest:\n********\n");

        $reservationId = $this->createTestReservation();

        $response = $this->deleteJson('api/reservations/delete/' . $reservationId);

        Log::info('$response it_deletes_a_reservation @ReservationDeleteRouteTest: ', [$response['message']]);

        $response->assertStatus(200)
            ->assertJsonFragment(['success' => true]);
    }

    #[Test]
    public function it_fails_to_delete_non_existing_reservation()
    {
        Log::info("\n********\nRUN TEST => it_fails_to_delete_non_existing_reservation @ReservationDeleteRouteTest:\n********\n");

        $fakeId = Str::uuid()->toString();

        $response = $this->deleteJson('api/reservations/delete/' . $fakeId);

        $response->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    #[Test]
    public function it_fails_with_invalid_id()
    {
        Log::info("\n********\nRUN TEST => it_fails_with_invalid_id @ReservationDeleteRouteTest:\n********\n");

        $invalidId = 012345;

        $response = $this->deleteJson('api/reservations/delete/' . $invalidId);

        $response->assertStatus(404);
    }
}
