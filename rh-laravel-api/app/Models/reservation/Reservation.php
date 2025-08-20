<?php

namespace App\Models\Reservation;

use App\Enums\Reservation\ReservationRoomType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasUuids;

    protected $table = 'reservations';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'guestName',
        'guestEmail',
        'comments',
        'checkInDate',
        'checkOutDate',
        'roomType',
    ];

    /**
     * Summary of casts
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'guestName'=> 'string',
        'guestEmail'=> 'string',
        'comments' => 'string',
        'checkInDate' => 'datetime:Y-m-d H:i:s',
        'checkOutDate' => 'datetime:Y-m-d H:i:s',
        'roomType' => ReservationRoomType::class,
    ];
}
