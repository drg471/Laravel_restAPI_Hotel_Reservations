<?php

declare(strict_types=1);

namespace App\Mail\Reservation;

use App\Models\Reservation\Reservation;
use Illuminate\Mail\Mailable;

class ReservationConfirmedMail extends Mailable
{
    private $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Summary of build
     * @return ReservationConfirmedMail
     */
    public function build()
    {
        return $this
        ->subject('Tu reserva ha sido confirmada')
        ->view('emails.reservations.confirmed')
        ->with([
            'reservation' => $this->reservation,
        ]);
    }
}