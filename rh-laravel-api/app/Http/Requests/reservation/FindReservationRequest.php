<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Validation\ValidationException;
use App\Enums\Reservation\ReservationRoomType;
use App\Http\Responses\Reservation\ReservationResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FindReservationRequest extends FormRequest
{
    /**
     * Summary of authorize
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Summary of rules
     * @return array{checkInDate: string, checkOutDate: string, comments: string, guestName: string, id: string, roomType: array<string|\Illuminate\Validation\Rules\Enum>}
     */
    public function rules(): array
    {
        return [
            'id' => 'string|min:1',
            'guestName' => 'string|min:1',
        ];
    }

    /**
     * Summary of failedValidation
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Validation\ValidationException
     * @return never
     */
    public function failedValidation(Validator $validator)
    {
        $response = ReservationResponse::errors(
            message: $validator->errors()->first(),
            status: 422
        );

        throw new ValidationException($validator, $response);
    }
}
