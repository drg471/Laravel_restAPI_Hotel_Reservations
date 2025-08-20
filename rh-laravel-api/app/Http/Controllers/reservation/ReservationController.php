<?php

declare(strict_types=1);

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Exceptions\Reservations\ReservationException;
use App\Http\Requests\Reservation\CreateReservationRequest;
use App\Http\Requests\Reservation\DeleteReservationRequest;
use App\Http\Requests\Reservation\FindReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Http\Responses\Reservation\ReservationResponse;
use App\Http\Services\Reservation\ReservationService;

class ReservationController extends Controller
{
    public function __construct(private ReservationService $reservationService) {}

    /**
     * Summary of createNewReservation
     * @param \App\Http\Requests\Reservation\CreateReservationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewReservation(CreateReservationRequest $request)
    {
        $data = $request->validated();
        $newReservationCreatedId = $this->reservationService->createNewReservation($data);

        return ReservationResponse::success(data: $newReservationCreatedId, status: 201);
    }

    /**
     * Summary of getAllReservations
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllReservations()
    {
        $reservations = $this->reservationService->getAllReservations();

        return ReservationResponse::success(data: $reservations, status: 200);
    }

    /**
     * Summary of findReservation
     * @param \App\Http\Requests\Reservation\FindReservationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findReservations(FindReservationRequest $request)
    {
        $filters = $request->validated();
        $reservations = $this->reservationService->findReservations($filters);

        return ReservationResponse::success(data: $reservations, status: 200);
    }

    /**
     * Summary of updateReservation
     * @param \App\Http\Requests\Reservation\UpdateReservationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateReservation(UpdateReservationRequest $request)
    {
        $data = $request->validated();
        $reservationUpdated = $this->reservationService->updateReservation($data);

        return ReservationResponse::success($reservationUpdated, 'reservation updated successfully', 200);
    }

    /**
     * Summary of deleteReservation
     * @param \App\Http\Requests\Reservation\DeleteReservationRequest $request
     * @throws \App\Http\Exceptions\Reservations\ReservationException
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteReservation(DeleteReservationRequest $request)
    {
        $id = $request->validated()['id'];

        $deleted = $this->reservationService->deleteReservation($id);

        if (!$deleted) {
            throw new ReservationException('Reservation not found', 404);
        }

        return ReservationResponse::success(message: 'Reservation deleted successfully', status: 200);
    }
}
