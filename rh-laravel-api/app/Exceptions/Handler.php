<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Http\Exceptions\Reservations\ReservationException;
use App\Http\Responses\Reservation\ReservationResponse;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return ReservationResponse::errors(message: $exception->getMessage(), status: 422);
        }

        if ($exception instanceof ModelNotFoundException) {
            return ReservationResponse::errors(message: $exception->getMessage(), status: $exception->getCode());
        }

        if ($exception instanceof ReservationException) {
            return ReservationResponse::errors(message: $exception->getMessage(), status: $exception->getCode());
        }

        return response()->json([
            'error' => 'Internal server error',
            'message' => $exception->getMessage(),
        ], 500);
    }
}
