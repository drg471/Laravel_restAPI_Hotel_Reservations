<?php

namespace Tests\Feature\Reservation;

use App\Enums\Reservation\ReservationRoomType;
use App\Storage\Reservation\ReservationStorage;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ReservationListRouteTest extends TestCase
{
    use Reservation_TestHelper;

    protected function setUp(): void
    {
        parent::setUp();
        ReservationStorage::clear();
    }

    #[Test]
    public function it_returns_multiple_reservations()
    {
        Log::info("\n********\nRUN TEST => it_returns_all_reservations @ReservationListRouteTest:\n********\n");

        $this->createTestReservation(); // reservation 1
        $this->createTestReservation(); // reservation 2
        $this->createTestReservation(); // reservation 3

        $response = $this->getJson('api/reservations/all');

        Log::info(
            '$response it_returns_all_reservations @ReservationListRouteTest: ' .
                json_encode($response['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $response->assertStatus(200);
    }

    #[Test]
    public function it_returns_single_reservation_when_only_one_exists()
    {
        Log::info("\n********\nRUN TEST => it_returns_single_reservation_when_only_one_exists @ReservationListRouteTest:\n********\n");

        $this->createTestReservation();

        $response = $this->getJson('api/reservations/all');

        Log::info(
            '$response it_returns_single_reservation_when_only_one_exists @ReservationListRouteTest: ' .
                json_encode($response['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    #[Test]
    public function it_returns_empty_list_when_no_reservations_exist()
    {
        Log::info("\n********\nRUN TEST => it_returns_empty_list_when_no_reservations_exist @ReservationListRouteTest:\n********\n");

        $response = $this->getJson('api/reservations/all');

        Log::info(
            '$response it_returns_empty_list_when_no_reservations_exist @ReservationListRouteTest: ' .
                json_encode($response['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [],
            ]);
    }

    #[Test]
    public function it_returns_reservations_with_expected_fields()
    {
        Log::info("\n********\nRUN TEST => it_returns_reservations_with_expected_fields @ReservationListRouteTest:\n********\n");

        $this->createTestReservation();

        $response = $this->getJson('api/reservations/all');

        Log::info(
            '$response it_returns_reservations_with_expected_fields @ReservationListRouteTest: ' .
                json_encode($response['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'guestName',
                            'guestEmail',
                            'comments',
                            'checkInDate',
                            'checkOutDate',
                            'roomType',
                        ],
                    ],
                ]
            );
    }
}
