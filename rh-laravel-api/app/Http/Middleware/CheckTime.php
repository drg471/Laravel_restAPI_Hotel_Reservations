<?php

namespace App\Http\Middleware;

use App\Http\Responses\Reservation\ReservationResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hour = now()->format('H');

        if($hour < 10 || $hour > 22){
            return ReservationResponse::errors(
                message: 'Acceso solo permitido entre las 10:00h y 22:00h',
                status: 403,
            );
        }

        return $next($request);
    }
}