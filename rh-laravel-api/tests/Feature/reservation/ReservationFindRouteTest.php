<?php

namespace Tests\Feature\Reservation;

use App\Storage\Reservation\ReservationStorage;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ReservationFindRouteTest extends TestCase
{
    use Reservation_TestHelper;

    protected function setUp(): void
    {
        parent::setUp();
        ReservationStorage::clear();
    }

    #[Test]
    public function it_finds_reservations_by_id()
    {
        Log::info("\n********\nRUN TEST => it_finds_reservations_by_id @ReservationRoutesTest:\n********\n");

        $reservationId = $this->createTestReservation();

        Log::info('self::$reservationId it_finds_reservations@ReservationRoutesTest', ['reservationId' => $reservationId]);

        $response = $this->getJson('api/reservations/find/', [
            'id' => $reservationId
        ]);

        Log::info(
            '$response it_finds_reservations@ReservationRoutesTest: ' .
                json_encode($response['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $response->assertStatus(200);
    }

    #[Test]
    public function it_finds_reservations_by_guestName()
    {
        Log::info("\n********\nRUN TEST => it_finds_reservations_by_guestName @ReservationRoutesTest:\n********\n");

        $this->createTestReservation();
        $guestName = 'Sergio Gómez';

        Log::info('self::$reservationId it_finds_reservations@ReservationRoutesTest', ['guestName' => $guestName]);

        $response = $this->getJson('api/reservations/find/', [
            'guestName' => $guestName
        ]);

        Log::info(
            '$response it_finds_reservations@ReservationRoutesTest: ' .
                json_encode($response['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $response->assertStatus(200);
    }

    #[Test]
    public function it_finds_reservations_by_id_and_guestName()
    {
        Log::info("\n********\nRUN TEST => it_finds_reservations_by_id_and_guestName @ReservationRoutesTest:\n********\n");

        $reservationId = $this->createTestReservation();
        $guestName = 'Sergio Gómez';

        $response = $this->getJson('api/reservations/find/', [
            'id' => $reservationId,
            'guestName' => $guestName,
        ]);

        $response->assertStatus(200);
    }

    #[Test]
    public function it_fails_when_reservation_not_found_by_fake_id()
    {
        Log::info("\n********\nRUN TEST => it_fails_when_reservation_not_found_by_fake_id @ReservationRoutesTest:\n********\n");

        $fakeId = 'fake-id';

        $response = $this->getJson('api/reservations/find/', [
            'id' => $fakeId
        ]);

        $response->assertStatus(404);
    }

    #[Test]
    public function it_fails_when_reservation_not_found_by_fake_name()
    {
        Log::info("\n********\nRUN TEST => it_fails_when_reservation_not_found_by_fake_name @ReservationRoutesTest:\n********\n");

        $fakeGuestName = 'fake-name';

        $response = $this->getJson('api/reservations/find/', [
            'guestName' => $fakeGuestName
        ]);

        $response->assertStatus(404);
    }
}
