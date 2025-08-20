<?php

namespace App\Http\Responses\Reservation;

class ReservationResponse 
{
    /**
     * Summary of success
     * @param mixed $data
     * @param mixed $message
     * @param mixed $status
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public static function success($data = null, $message = 'Operation completed successfully.', $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Summary of errors
     * @param mixed $data
     * @param mixed $message
     * @param mixed $status
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public static function errors($data = null, $message = 'An error has occurred.', $status = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}