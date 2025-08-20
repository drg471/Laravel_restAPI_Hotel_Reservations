<?php

namespace App\Models\Reservation;

use App\Enums\Reservation\ReservationRoomType;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class Invoice
{
    public string $id;
    public string $reservationId;
    public string $guestName;
    public string $guestEmail;
    public ReservationRoomType $roomType;
    public Carbon $checkInDate;
    public Carbon $checkOutDate;
    public float $totalAmount;

    public function __construct(Reservation $reservation)
    {
        $this->id = Str::uuid()->toString();
        $this->reservationId = $reservation->id;
        $this->guestName = $reservation->guestName;
        $this->guestEmail = $reservation->guestEmail;
        $this->roomType = $reservation->roomType;
        $this->checkInDate = $reservation->checkInDate;
        $this->checkOutDate = $reservation->checkOutDate;
        $this->totalAmount = $this->calculateAmount();
    }

    protected function calculateAmount(): float
    {
        $nights = $this->checkInDate->diffInDays($this->checkOutDate);

        $rate = match ($this->roomType) {
            ReservationRoomType::single => 80.0,
            ReservationRoomType::double => 120.0,
            ReservationRoomType::family => 160.0,
            ReservationRoomType::suite  => 220.0,
        };

        return round($nights * $rate, 2);
    }

    public function toArray(): array
    {
        return [
            'invoice_id'     => $this->id,
            'reservation_id' => $this->reservationId,
            'guest_name'     => $this->guestName,
            'guest_email'    => $this->guestEmail,
            'room_type'      => $this->roomType->value,
            'check_in'       => $this->checkInDate->toDateString(),
            'check_out'      => $this->checkOutDate->toDateString(),
            'total_amount'   => $this->totalAmount,
        ];
    }
}
