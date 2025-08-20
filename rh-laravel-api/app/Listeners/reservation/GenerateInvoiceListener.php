<?php

declare(strict_types=1);

namespace App\Listeners\Reservation;

use App\Events\Reservation\ReservationCreatedEvent;
use App\Models\Reservation\Invoice;
use Illuminate\Support\Facades\Log;

class GenerateInvoiceListener
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Summary of handle
     * @param \App\Events\Reservation\ReservationCreatedEvent $event
     * @return void
     */
    public function handle(ReservationCreatedEvent $event)
    {
        $reservation = $event->reservation;

        $invoice = new Invoice($reservation);

        Log::debug("Factura:\n" . json_encode($invoice, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}
