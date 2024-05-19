<?php

namespace App\Http\Requests;

use App\Models\HoleBooking;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHoleBookingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('hole_booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:hole_bookings,id',
        ];
    }
}
