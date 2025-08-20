<?php

declare(strict_types=1);

namespace App\Http\Services\Reservation;

use App\Events\Reservation\ReservationCreatedEvent;
use App\Http\Exceptions\Reservations\ReservationException;
use App\Http\Repositories\Reservation\ReservationRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class ReservationService
{
    public function __construct(private ReservationRepository $reservationRepository) {}

    /**
     * Summary of createNewReservation
     * @param mixed $data
     * @throws \App\Http\Exceptions\Reservations\ReservationException
     * @return string
     */
    public function createNewReservation($data)
    {
        try {
            $data = array_merge($data, [
                'checkInDate' => now()->addHour(),
                'checkOutDate' => empty($data['checkOutDate'])
                    ? now()->addDays(30)
                    : Carbon::parse($data['checkOutDate'])->format('Y-m-d H:i:s'),
            ]);

            $newReservationCreated = $this->reservationRepository->create($data);

            if (!$newReservationCreated) {
                throw new ReservationException('Reservation not created', 400);
            }

            event(new ReservationCreatedEvent($newReservationCreated));

            return $newReservationCreated->id;
        } catch (Exception $e) {
            Log::error('Error in create new reservation [Service]' . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    /**
     * Summary of getAllReservations
     * @throws \App\Http\Exceptions\Reservations\ReservationException
     * @return array
     */
    public function getAllReservations()
    {
        try {
            $reservations = $this->reservationRepository->all();

            return $reservations;
        } catch (Exception $e) {
            Log::error('Error in get all reservations [Service]' . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    /**
     * Summary of findReservations
     * @param mixed $filters
     * @throws \App\Http\Exceptions\Reservations\ReservationException
     * @return array|\App\Models\Reservation\Reservation
     */
    public function findReservations($filters)
    {
        $reservations = $this->reservationRepository->find($filters);

        if (!$reservations) {
            throw new ReservationException('Reservation not found', 404);
        }

        return $reservations;
    }

    /**
     * Summary of updateReservation
     * @param mixed $data
     * @throws \App\Http\Exceptions\Reservations\ReservationException
     * @return object
     */
    public function updateReservation($data)
    {
        $data['checkOutDate'] = empty($data['checkOutDate'])
            ? Carbon::parse($data['checkInDate'])->addDays(30)
            : Carbon::parse($data['checkOutDate'])->format('Y-m-d H:i:s');

        $reservationUpdated = $this->reservationRepository->update($data['id'], $data);

        if (!$reservationUpdated) {
            throw new ReservationException('Reservation not found', 404);
        }

        return $reservationUpdated;
    }

    /**
     * Summary of deleteReservation
     * @param mixed $id
     * @return bool
     */
    public function deleteReservation($id)
    {
        return  $this->reservationRepository->delete($id);
    }
}
