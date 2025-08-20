<?php

declare(strict_types=1);

namespace App\Http\Repositories\Reservation;

use App\Contracts\IBaseRepository;
use App\Models\Reservation\Reservation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReservationRepository implements IBaseRepository
{
    public function __construct(private Reservation $reservation) {}

    /**
     * Summary of create
     * @param array $data
     * @return Reservation
     */
    public function create(array $data): object
    {
        $reservation = $this->reservation->create([
            'id' => Str::uuid()->toString(),
            'guestName' => $data['guestName'],
            'guestEmail' => $data['guestEmail'],
            'comments' => $data['comments'],
            'checkInDate' => $data['checkInDate'],
            'checkOutDate' => $data['checkOutDate'],
            'roomType' => $data['roomType'],
        ]);

        return $reservation;
    }

    /**
     * Summary of all
     * @return array
     */
    public function all(): array
    {
        $reservations = $this->reservation->all()->toArray();

        return $reservations;
    }

    /**
     * Summary of find
     * @param mixed $id
     * @return Reservation|null
     */
    public function find($filters): array
    {
        $query = $this->reservation->newQuery();

        $query
            ->when(
                $filters['id'] ?? null,
                fn($q, $id) =>
                $q->where('id', $id)
            )
            ->when(
                $filters['guestName'] ?? null,
                fn($q, $guestName) =>
                $q->where('guestName', 'like', "%$guestName%")
            );

        $reservations = $query->get()->toArray();

        return $reservations;
    }

    /**
     * Summary of update
     * @param mixed $id
     * @param array $data
     * @return Reservation|null
     */
    public function update($id, array $data): ?object
    {
        $reservation = $this->reservation->find($id);

        if (!$reservation) {
            return null;
        }

        $reservation->update($data);

        return $reservation;
    }

    /**
     * Summary of delete
     * @param mixed $id
     * @return bool
     */
    public function delete($id): bool
    {
        $reservation = $this->reservation->find($id);

        if (!$reservation) {
            return false;
        }

        return $reservation->delete();
    }
}
