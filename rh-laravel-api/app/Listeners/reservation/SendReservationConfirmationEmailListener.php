<?php

namespace App\Listeners\Reservation;

use App\Events\Reservation\ReservationCreatedEvent;
use App\Mail\Reservation\ReservationConfirmedMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendReservationConfirmationEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct(){}

    /**
     * Summary of handle
     * @param \App\Events\Reservation\ReservationCreatedEvent $event
     * @return void
     */
    public function handle(ReservationCreatedEvent $event): void
    {
        Log::info('Enviando correo de confirmación a: ' . $event->reservation->guestEmail);

        $reservation = $event->reservation;

        Mail::to($reservation->guestEmail)->send(new ReservationConfirmedMail($reservation));
    }
}