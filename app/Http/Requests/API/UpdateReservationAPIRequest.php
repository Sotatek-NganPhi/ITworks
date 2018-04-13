<?php

namespace App\Http\Requests\API;

use App\Models\Reservation;
use App\Http\Requests\API\BaseRequest;

class UpdateReservationAPIRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Reservation::$rules;
    }
}
