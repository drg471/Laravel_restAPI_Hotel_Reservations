<?php

namespace App\Enums\Reservation;

enum ReservationRoomType: string
{
    case single = 'single';
    case double = 'double';
    case family = 'family';
    case suite = 'suite';
}